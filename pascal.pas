Program Physics; 

Const 
   g=9.81; 
   u=0.028; 
   ka=0.0065;
   ratm=8.31; 
Var 
   ph,pk,po,dh,h,t1,tk,vk,m:real; 
   r,l,alpha,df,o,k:real; 
   file,inform:text; 
   Tmax:real ; 

procedure readinfo; 

begin 
  assign(file,'C:\data.txt'); 
  assign(inform,'C:\info.txt'); 
  rewrite(inform); 
  writeln(inform,'H(m)          P(na)          T(N)'); 
  reset(file); 
  readln(file,R); 
  readln(file,l); 
  readln(file,alpha); 
  readln(file,df); 
  readln(file,o); 
  readln(file,k); 
  Tmax:=0; 
  m:=180; 
  vk:=650; 
  po:=100000; 
  t1:=273; 
  tk:=1/(1/t1-ratm*m/vk/po/u); 
  h:=0; 
end; 

Function step(x,y:real):real; 
Begin 
  step:=exp(y*ln(x)); 
end; 

function dp(x:real):real; 
begin 
  if x>=l then 
    begin 
      x:=x-l; 
      dp:=po*(exp(-u*g/ratm/tk*x)-step(1-ka*x/(t1-ka*h),u*g/ratm/ka));
     {dp:=po*u*g*x/ratm*(1/t1-1/tk);}
       
    end; 
end; 

function contur(x:real):real; 
begin 
  contur:=0; 
  if (x>=l) and (x<=k) then 
    contur:=sin(alpha)/cos(alpha)*x; 
  if (x>k) and (x<=o+r) then 
    contur:=sqrt(R*R-sqr(x-o)); 
end; 

procedure seredovushche; 
begin 
  brush(1,130,130,130); 
  rectangle(-1,-1,3000,3000); 
  line(round(l*80),0,round(l*80),2650); 
  line(0,620,2240,620); 
  moveto(round(l*80),620); 
  dh:=l-0.1; 
  repeat 
    dh:=dh+0.1; 
    lineto(round(80*dh),round(620-80*contur(dh))); 
  until dh>=o+r; 
  brush(1,100,100,100); 
  fill(round(80*o),615); 
end; 

function dcontur(x:real):real; 
var 
   K:real; 
begin 
  k:=0.00001; 
  dcontur:=(contur(x+k)-contur(x))/k; 
end; 

function cosb(x:real):real; 
begin 
  if (x>=l)and(x<=o+r) then 
    cosb:=abs(sin(arctan(1/dcontur(x)))); 
end; 

function sinb(x:real):real; 

var 
   d:real; 
begin 
  d:=-sqrt(1-sqr(cosb(x))); 
  if x>o then 
    d:=-d; 
  sinb:=d; 
end; 

function fun1(x:real):real; 
{duferencial sulu natiag u na klijonci z tochnistiju do koef    df/dh} 

begin 
  fun1:=2*pi*dp(x)*contur(x)*sqrt(1+sqr(dcontur(x)))*cosb(x); 
end; 

function t(x:real):real; 

begin 
  t:=fun1(x)/2/pi; 
end; 

function fun2(x:real):real; 

begin 
  fun2:=2*pi*dp(x)*contur(x)*sqrt(1+sqr(dcontur(x)))*sinb(x); 
end; 

function Integrate2(b:real):real; 

var 
   sum,dx,a:real; 
   n,i:integer; 
begin 
  a:=l; 
  n:=100; 
  dx:=(b-a)/n; 
  sum:=0; 
  for i:=0 to n-1 do 
    sum:=sum+(fun2(a+dx*i)+fun2(a+dx*(i+1)))*dx/2; 
  integrate2:=sum; 
end; 

procedure points(x,y,r:real); 

begin 
  ellipse(round(x),round(y),round(x+r),round(y+r)); 
end; 

Begin 
  readinfo; 
  seredovushche; 
  dh:=l-0.01; 
  repeat 
    dh:=dh+0.001; 
    writeln(inform,dH:4:3,'          ',dp(dh):5:3,'            ',T(dh):4:3); 
    pen(2,255,0,0); 
    points(dh*80,620-80*contur(dh),1); 
    points(dh*80,620-80*(contur(dh)+fun1(dh)/700),2); 
    pen(2,133,255,133); 
    points(dh*80,620-410*cosb(dh),1); 
    points(dh*80,620-410*sinb(dh),1); 
    pen(2,0,0,255); 
    points(dh*80,620-fun1(dh)/1.5,1); 
    points(dh*80,620-T(dh)/1.5,2); 
    moveto(100,100); 
    writeln(T(dh)/g:4:4); 
    if t(dh)>tmax then 
      tmax:=t(dh); 
    points(dh*80,620-integrate2(dh)/20,2); 
    pen(2,255,0,255); 
    points(dh*80,620-14*dp(dh),2); 
  until dh>o+r; 
  moveto(50,20); 
  writeln('Tatm=',t1-273:5:1,'C   tk=',tk-273:5:1,'C   dT=',tk-t1:4:1); 
  Writeln('Tmax(dh)=',Tmax/g:4:1,'kg/m'); 
  writeln('dPmax(o+r)=',dp(o+r-0.001):4:1,'Pa'); 
  writeln('Fx=',integrate2(o+r-0.001)/g:4:1,'kg'); 
  close(inform); 
  moveto(0,0); 
  readln; 
end.
