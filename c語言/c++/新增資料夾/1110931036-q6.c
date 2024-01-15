#include<stdio.h>
#include<stdlib.h>

void main(void)
{
	float in , out;
	puts("請輸入數值：");
	scanf("%f" , &in);
	out = in*in*in;
	printf("\n%.3f的三次方為%.3f" , in , out);
 } 
