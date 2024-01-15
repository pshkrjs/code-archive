#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/*
	creates a file to save the version history in format-
	v:n - version number
	a/d: - Appended line or deleted line number
	e:n - End of thr version
*/
int create_history(int, char [][12], int, int *);

/*
	Records the difference between the latest recorded version of file and the actual file
*/
int changeInFile(char [][12], int, int, char[]);

/*
	Checking if the argument is a number or a string
*/
int argument_type(char []);

int main(int argc, char * argv[])
{
	int argType,typed_ver,current_ver = -1,totalLines,i,diff;
	char file[20][12];

	if (argc == 2)
	{

		argType = argument_type(argv[1]);

		if(argType == 1) //Commit the latest version of file
		{
			totalLines = create_history(0, file, 1, &current_ver);
			int diff = changeInFile(file, current_ver, totalLines, argv[1]);
			if(diff!=0)
				{
					printf("Committed %s\n",argv[1]);
				}
			 else
		    {
					printf("There are no changes .\n");
		    }
		}
		else if(argType == 2) //Display the version requested by the user
		{
			int version = atoi(argv[1]);
			totalLines = create_history(version, file, 0, &current_ver);

			//printf("\n%d",current_ver);
			printf("Version %d :\n",version);
			for(i=0; i<totalLines; i++)
				printf("%s\n",file[i]);
		}
	}
	else
	{
		//Usage
		printf("\tsvc file.txt - commit file");
		printf("\nsvc N - display Version N");
		exit(0);
	}
	return 0;
}

int create_history(int version, char file[20][12], int type, int * current_ver)
{
	int i,counter = 0;

	FILE * history ;
	char prefix,data[12];
	char * line = NULL;
    ssize_t read_bytes = 0;
	size_t size = 0;
	int flag = 0,flag1 = 0,v=0;

	history = fopen("versionHistory", "r");
	if(history != NULL)
	{
		flag1 = 0;
		for(i=0; i<20; i++)
			file[i][0] = '\0';

		while( (read_bytes = getline(&line, &size, history)) != -1)
		{
			line[strlen(line)-1] = '\0';

			prefix = line[0];
			strcpy(data, line+2);

			switch(prefix)
			{
				case 'a':
				{
					strcpy(file[counter], data);
					counter++;
					break;
				}
				case 'd':
				{
					int j = atoi(data);
					for(i = j; i<counter; i++)
						strcpy(file[i], file[i+1]);
					counter--;
					break;
				}
				case 'v':
				{
					v = atoi(data);
					if(v == version)
						flag = 1;
					break;
				}
				case 'e':
				{
					if(flag == 1 && type == 0)
					{
						flag1 = 1;
						break;
						}
					break;
				}
			}
			if(flag1)
				break;
		}
		*current_ver = v;
		free(line);
		fclose(history);
		return counter;
	}
	return 0;
}

int changeInFile(char file[20][12], int prevVer, int totalLines, char textfile[])
{
	FILE * currentFile ;
	FILE * history ;

	int lines = 0,changes=0;

	char * line = NULL;
	size_t size = 0;
	ssize_t read_bytes = 0;

	char changedLine[12] = "\0";

	currentFile = fopen(textfile, "r");
	if(currentFile == NULL)
	{
		printf("\nNo such file in the working directory");
	}

	history = fopen("versionHistory", "a");

	while( (read_bytes = getline(&line, &size, currentFile)) != -1 )
	{
		// line[strlen(line)] = '\0';
		if(line[strlen(line)-1]=='\n')
		{
			line[strlen(line)-1]='\0';
		}
		else
		{
			line[strlen(line)]='\0';
		}

		if(lines < totalLines)
		{
			if(strcmp(file[lines], line) != 0)
			{
				sprintf(changedLine, "d:%d\n", lines);
				break;
			}
		}
		else
		{
			sprintf(changedLine, "a:%s\n", line);
		}
		lines++;
	}

	if(lines < totalLines)
	{
		sprintf(changedLine, "d:%d\n", lines);
	}

	if(strlen(changedLine) > 0)
	{
		fprintf(history, "v:%d\n", prevVer + 1);
		fprintf(history, "%s", changedLine);
		fprintf(history, "e:n\n");
		changes = 1;
	}

	fclose(history);
	fclose(currentFile);

	return changes;
}

int argument_type(char arg[])
{
	int i = 0, arg_type;
	for(i=0; arg[i]!='\0'; i++)
	{
		if(arg[i] >= '0' && arg[i] <= '9')
			arg_type = 2;
		else
		{
			arg_type = 1;
			break;
		}
	}
	return arg_type;
}