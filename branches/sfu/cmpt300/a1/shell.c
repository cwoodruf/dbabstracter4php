/* $Id$ */
#include <sys/wait.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <stdio.h>
#include <fcntl.h>
#include <sys/stat.h>

#define MAXCARGC 255
void getparse(char **cargv, int *infd, int *outfd, char *cmd, int *background, pid_t cpid);
pid_t dofork(char **cargv, char **envp, int *infd, int *outfd, int *background);
void dowait(pid_t cpid);

int pfd[2] = {-1,-1}; /* for piping */

int main(int argc, char *argv[], char *envp[])
{

	/* for child processes */
	int infd;			/* input redirect file descriptor */
	int outfd;			/* output redirect file descriptor */
	int cpid;			/* child process id */
	int background = 0;   		/* for daemonizing */
	char cmd[MAXCARGC] = ""; 	/* the raw command */
	char *cargv[MAXCARGC];   	/* the argv list created from the command */

	cargv[0] = 0;
	cpid = infd = outfd = -1;

	while (1) {
		getparse(cargv,&infd,&outfd,cmd,&background,cpid);
		cpid = dofork(cargv,envp,&infd,&outfd,&background);
	}
}

/* get and parse entered command */
void getparse(char **cargv, int *infd, int *outfd, char *cmd, int *background, pid_t cpid) {

	char cbuff[MAXCARGC] = "";	/* command buffer */
	char *infrom; 			/* input redirection */
	char *outto;			/* output redirection */
	char *ctok;         		/* pointer to next argv token */
	char cchar;                     /* test first character of argument */
	int i,cargc;          		/* the argument count */
	char *carg;			/* a single argument */
	int newcmd = 0;			/* new command was entered */
	int redirection;		/* we found a | > < character */
	mode_t mode = S_IRUSR | S_IWUSR | S_IRGRP | S_IROTH;

	cargc = 0;
	do {
		/* clean up from previous command see malloc below */
		i = 0;
		while (cargv[i]) {
			free(cargv[i]);
			i++;
		}
		cargv[0] = NULL;
		infrom = "";
		outto = "";
		if (infd >= 0) close(*infd); 
		if (outfd >= 0) close(*outfd);
		*infd = *outfd = -1;
		*background = redirection = 0;

		/* get a command if we aren't in the middle of a pipe */
		if (strlen(cmd) == 0) {
			printf("Ctrl-C to exit. Enter a command: ");
			fgets(cmd,MAXCARGC,stdin);
			newcmd = 1;
		} else {
			/* we are doing the second part of a pipe */
			if (pfd[0] == -1) {
				perror("no pipe initiated");
				exit(EXIT_FAILURE);
			}
			*infd = pfd[0];
		}
		/* strtok mangles the strings it parses */
		strcpy(cbuff,cmd);

		for (
			cargc = 0, ctok = strtok(cbuff," \n"); 
			cargc < MAXCARGC; 
			ctok = strtok(NULL," \n")
		) {
			if (ctok == NULL) break;

			cchar = ctok[0];
			switch (cchar) {
			case '|': 
				/* remember rest of command - this will include the leading '|' */
				carg = strstr(cmd,ctok);
				/* skip the leading '|' */
				strcpy(cmd,carg+1);

				if (pipe(pfd) == -1) {
					perror("pipe");
					exit(EXIT_FAILURE);
				}
				*outfd = pfd[1];

				cargv[cargc] = NULL;
				return;
			case '<':
				/* get input from a file */
				redirection = 1;
				if (strlen(ctok+1) > 0) infrom = ctok+1;
				else infrom = strtok(NULL," \n");
				if (strlen(infrom)) {
					if ((*infd = open(infrom, O_RDONLY)) == -1) {
						perror("open input redirect");
						exit(EXIT_FAILURE);
					}
				}
				break;
			case '>': 
				/* redirecting output to a file */
				redirection = 1;
				if (strlen(ctok+1) > 0) outto = ctok+1;
				else outto = strtok(NULL," \n");
				if (strlen(outto)) {
					if ((*outfd = open(outto, O_RDWR|O_CREAT,mode)) == -1) {
						perror("open output redirect");
						exit(EXIT_FAILURE);
					}
				}
				break;
			case '&':
				*background = 1;
				break;
			case '!': /* not a standard shell operator but its the equivalent to "fg" */
printf("child process %d\n", cpid);
				*background = 0;
				if (cpid >= 0) dowait(cpid);
				cpid = -1; /* in case someone types !! */
				break;
			default: 
				/* we assume with redirection/backgrounding that we have our command already */
				if (redirection || *background) break;
				cchar = 0; 
				if ((carg = malloc(strlen(ctok)+1)) != NULL) {
					strcpy(carg,ctok);
					cargv[cargc++] = carg;
				} else {
					perror("out of memory!");
					exit(EXIT_FAILURE);
				}
			}
		}
	} while (cargc == 0);

	/* execve needs a null terminated list of strings */
	cargv[cargc] = NULL;

	/* clear the command */
	for (i=0; i<MAXCARGC; i++) {
		cmd[i] = 0;
	}
}

/* 
 * initate the fork so we can run the command 
 * we need to use fork as exec* functions will give control over to
 * the program it tries to run
 * if there is a command in cmd then that means you are doing a pipe
 * partly adapted from execve and waitpid linux man page examples 
 */
pid_t dofork(char **cargv, char **envp, int *infd, int *outfd, int *background) {

	pid_t cpid;
	int i;

	cpid = fork();
	if (cpid == -1) {
		 perror("fork");
		 exit(EXIT_FAILURE);
	}

	if (cpid == 0) { 		/* Code executed by child */

		/* display what we are sending execve unless we background */
		if (!*background) {
			i = 0;
			while (cargv[i]) {
				fprintf(stderr, "arg[%d] %s\n", i, cargv[i]);
				i++;
			}
		}
		if (*infd >= 0) {
			close(STDIN_FILENO);
			dup(*infd);
		}
		if (*outfd >= 0) {
			close(STDOUT_FILENO);
			dup(*outfd);
		}
		execve(cargv[0], cargv, envp);
		perror("execve");	/* execve() only returns on error */
		exit(EXIT_FAILURE);

	} else {			/* Code executed by parent */

		/* to run a process in the background don't invoke wait* */
		if (*background) return;

		/* otherwise check the exit status */
		dowait(cpid);
	}
	return cpid;
}

/* run the waitpid func to find out what the exit status was for the child */
void dowait(pid_t cpid) {

	pid_t w;
	int status;

	do {
		w = waitpid(cpid, &status, WUNTRACED | WCONTINUED);
		if (w == -1) {
			perror("waitpid");
			exit(EXIT_FAILURE);
		}

		if (WIFEXITED(status)) {
			printf("exited, status=%d\n", WEXITSTATUS(status));
		} else if (WIFSIGNALED(status)) {
			printf("killed by signal %d\n", WTERMSIG(status));
		} else if (WIFSTOPPED(status)) {
			printf("stopped by signal %d\n", WSTOPSIG(status));
		} else if (WIFCONTINUED(status)) {
			printf("continued\n");
		}
	} while (!WIFEXITED(status) && !WIFSIGNALED(status));
}

