#include<stdio.h>
#include<stdlib.h>

void main(void)
{

 int ch1;
 int ch2;
 int ch3;
 int p1;  
 float f1,a , b , c ;
 
	char *n1[200];

	printf("請輸入姓名：");
	scanf("%s" ,&n1);
	printf("請輸入計概成績：");
	scanf("%d" , &ch1);
    printf("請輸入計數學成績：");
	scanf("%d" , &ch2);
	printf("請輸入英文成績："); 
	scanf("%d" , &ch3);
	a=ch1,b=ch2,c=ch3;
	p1 = ch1+ch2+ch3;
	f1=(a+b+c)/3;
	printf("計算中...........");
	printf("\n%s的成績如下：" , n1);
	printf("\n================");
	printf("\n   計概：%d" , ch1);
	printf("\n   數學：%d" , ch2);
	printf("\n   英文：%d" , ch3);
	printf("\n================");
	printf("\n   總分：%d" , p1);
	printf("\n   平均：%.2f" , f1);
 } 
