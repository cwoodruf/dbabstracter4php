#include <sys/wait.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <stdio.h>
#include <fcntl.h>
#include <sys/stat.h>

#define MAXCARGC 255

/* adapted by cal woodruff from execve and waitpid linux man page examples */
int main(int argc, char *argv[], char *envp[])
{
	pid_t cpid, w;
	int status;
	mode_t mode = S_IRUSR | S_IWUSR | S_IRGRP | S_IROTH;

	/* for child processes */
	char cmd[MAXCARGC] = ""; 	/* the raw command */
	char *infrom; 			/* input redirection */
	int infd;			/* input redirect file descriptor */
	char *outto;			/* output redirection */
	int outfd;			/* output redirect file descriptor */
	char *ctok;         		/* pointer to next argv token */
	char *cargv[MAXCARGC];   	/* the argv list created from the command */
	char cchar;                     /* test first character of argument */
	int i,cargc;          		/* the argument count */
	int redirection;		/* we found a | > < character */

	while (1) {
		cargc = 0;
		/* get and parse entered command */
		do {
			printf("Ctrl-C to exit. Enter a command: ");
			fgets(cmd,MAXCARGC,stdin);
			infrom = "";
			outto = "";
			redirection = 0;
			for (
				cargc = 0, ctok = strtok(cmd," \n"); 
				cargc < MAXCARGC; 
				ctok = strtok(NULL," \n")
			) {
				if (ctok == NULL) break;

				cchar = ctok[0];
				switch (cchar) {
				/* case '|': ideally you'd want pipes to work recursively? */
				case '<':
					redirection = 1;
					if (strlen(ctok+1) > 0) infrom = ctok+1;
					else infrom = strtok(NULL," \n");
					break;
				case '>': 
					redirection = 1;
					if (strlen(ctok+1) > 0) outto = ctok+1;
					else outto = strtok(NULL," \n");
					break;
				default: 
					/* we assume with redirection that we have our command already */
					if (redirection) break;
					cchar = 0; 
					cargv[cargc++] = ctok;
				}
			}
		} while (cargc == 0);

		/* execve needs a null terminated list of strings */
		cargv[cargc] = NULL;

		/* 
		 * initate the fork so we can run the command 
		 * we need to use fork as exec* functions will give control over to
		 * the program it tries to run
		 */
		cpid = fork();
		if (cpid == -1) {
			 perror("fork");
			 exit(EXIT_FAILURE);
		}

		if (cpid == 0) { 		/* Code executed by child */

			for (i=0; i<cargc; i++) {
				fprintf(stderr, "arg[%d] %s\n", i, cargv[i]);
			}
			/* get input from a file */
                        if (strlen(infrom)) {
                                if ((infd = open(infrom, O_RDONLY)) == -1) {
                                        perror("open input redirect");
                                        exit(EXIT_FAILURE);
                                }
                                close(STDIN_FILENO);
                                dup(infd);
                        }

			/* redirecting output to a file */
                        if (strlen(outto)) {
                                if ((outfd = open(outto, O_RDWR|O_CREAT,mode)) == -1) {
                                        perror("open output redirect");
                                        exit(EXIT_FAILURE);
                                }
                                close(STDOUT_FILENO);
                                dup(outfd);
                        }

			execve(cargv[0], cargv, envp);
			perror("execve");	/* execve() only returns on error */
			exit(EXIT_FAILURE);

		} else {			/* Code executed by parent */
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
			 /* exit(EXIT_SUCCESS); */
		}
	}
}

