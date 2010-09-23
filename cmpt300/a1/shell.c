#include <sys/wait.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <stdio.h>

#define MAXCARGC 255

/* adapted by cal woodruff from execve and waitpid linux man page examples */
int main(int argc, char *argv[], char *envp[])
{
	pid_t cpid, w;
	int status;

	/* for child processes */
	char cmd[MAXCARGC] = ""; 	/* the raw command */
	char *infrom; 			/* input redirection */
	char *outto;			/* output redirection */
	char *ctok;         		/* pointer to next argv token */
	char *cargv[MAXCARGC];   	/* the argv list created from the command */
	char cchar;                     /* test first character of argument */
	int i,cargc;          		/* the argument count */

	while (1) {
		cargc = 0;
		/* get and parse entered command */
		do {
			printf("Ctrl-C to exit. Enter a command: ");
			fgets(cmd,MAXCARGC,stdin);
			for (
				cargc = 0, ctok = strtok(cmd," \n"); 
				cargc < MAXCARGC ; 
				ctok = strtok(NULL," \n"), cargc++
			) {
				if (ctok == NULL) {
					cargv[cargc] = NULL;
					break;
				}
				cchar = ctok[0];
				switch (cchar) {
				/* case '|': ideally you'd want pipes to work recursively? */
				case '<':
					if (strlen(ctok+1) > 0) infrom = ctok+1;
					else infrom = strtok(NULL," \n");
					break;
				case '>': 
					if (strlen(ctok+1) > 0) outto = ctok+1;
					else outto = strtok(NULL," \n");
					break;
				default: 
					cchar = 0; 
					cargv[cargc] = ctok;
				}
				if (cchar) break;
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
printf("running %s\n", cargv[0]);
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

