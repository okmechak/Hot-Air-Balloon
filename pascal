Program sdfsdf; 

Const 
   g=9.81; 
   u=0.028; 
   ka=0.0065; 
Var 
   ph,pk,po,dh,h,t1,tk,vk,m:real; 
   r,l,alpha,df,o,k:real; 
   file:text; 

Function step(x,y:real):real; 
Begin 
  step:=exp(y*ln(x)); 
end; 

function contur(x:real):real; 
begin 
  contur:=random; 
  if (x>=l) and (x<=k) then 
    contur:=sin(alpha)/cos(alpha)*x; 
  if (x>k) and (x<=o+r) then 
    contur:=sqrt(R*R-sqr(x-o)); 
end; 

function dp(x:real):real; 
begin  
  if x>l then 
    dp:=po*(exp(-u*g/r/tk*(x-l))-step(1-ka*(x-l)/(t1-ka*h),u*g/r/ka)) 
  else 
    dp:=0.0001; 
end; 

function proekcp(x:real):real; 

var 
   beta:real; 
begin 
  beta:=arctan(-0.0001/(Contur(x+0.0001)-contur(x))); 
  proekcp:=dp(x)*ABS(cos(pi/2-beta)); 
end; 

Begin 
  assign(file,'F:\data.txt'); 
  reset(file); 
  readln(file,R); 
  readln(file,l); 
  readln(file,alpha); 
  readln(file,df); 
  readln(file,o); 
  readln(file,k); 
  readln(file,vk);
  m:=120; 
  po:=100000; 
  t1:=12+273; 
  tk:=1/(1/t1-r*m/vk/po/u); 
  h:=0; 
  dh:=-0.5; 
  repeat 
    dh:=dh+0.001; 
    pen(1,255, 0, 255); 
    point(round(dh*70),round(70*contur(dh))); 
    pen(1,255, 0, 0); 
    point(round(dh*70),600-round(20*proekcp(dh))); 
    point(round(dh*70),600-round(20*dp(dh))); 
  until dh>18; 
end.
