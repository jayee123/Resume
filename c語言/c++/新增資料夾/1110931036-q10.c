#include<stdio.h>
#include<stdlib.h>

void main(void)
{
	char str1[80];
	printf("請輸入字串：");
	fgets(str1,80,stdin);
	printf("======您輸入的字串如下======\n");
	printf("str1=%s",str1); 
 } 
