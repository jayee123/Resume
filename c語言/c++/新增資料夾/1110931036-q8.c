#include<stdio.h>
#include<stdlib.h>

void main(void)
{
	int in;
	float out1 , out2;
	printf("請輸入數值：");
	scanf("%d" , &in);
	out1 = in * 3.306;
	out2 = in * 3.95;
	printf("%d坪=%.2f平方公尺", in , out1);
	printf("\n%d坪=%.2f平方碼", in , out2);
	
 } 
