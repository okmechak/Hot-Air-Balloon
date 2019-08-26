program Model_3d_of_baloon; 
var 
   pxc,pyc,i,xm,ym,km,n,chois,j:integer; 
   xp,yp,zp,fv,croc:real; 
   xl1,yl1,zl1:array[0..30,0..30] of real; 
   alpha,beta,gama,kgrad,kut,kut2,kut3:real; 
   key:char; 
   r,l,alphak,df,o,k,fvx,fvy:real; 
   file:text; 
label 14,12; 

      
procedure readinfo; 
begin 
  assign(file,'C:\data.txt'); 
  reset(file); 
  readln(file,R); 
  readln(file,l); 
  readln(file,alpha); 
  readln(file,df); 
  readln(file,o); 
  readln(file,k); 
  key:='F';
  kut2:=0;
  kut3:=0;
  croc:=0.1; 
  zp:=10; 
  yp:=0; 
  xp:=0;
  n:=0;
  pxc:=630;
  pyc:=320;
  fv:=0.000003;
  fvx:=0.00000;
  fvy:=0.00000;
end;    


function contur(x:real):real; 
begin 
  contur:=0; 
  if(x>=l)and(x<=k)then contur:=sin(alpha)/cos(alpha)*x; 
  if(x>k)and(x<=o+r)then contur:=sqrt(R*R-sqr(x-o)); 
end; 

procedure line_3d(x1,y1,z1,x2,y2,z2:real);
var d1,d2:real;
    cdf:integer;
begin
  if (z1+z2)/2>0 then cdf:=1
   else cdf:=3;
  d1:=sqrt(fvx*sqr(x1+xp)+fvy*sqr(y1+yp)+fv*sqr(z1+zp));
  d2:=sqrt(fvx*sqr(x2+xp)+fvy*sqr(y2+yp)+fv*sqr(z2+zp));
  if abs(z1+zp)>0.1 then pen(cdf,round(455/sqrt(abs(z1+zp))),round(455/sqrt(abs(z1+zp))),0);
  if 455/sqrt(abs(z1+zp))>255 then pen(5,255,255,0);
  if(z1+zp>0)and(z2+zp>0)then line(pxc+round((xp+x1)/d1),pyc+round((yp+y1)/d1),pxc+round((xp+x2)/d2),pyc+round((yp+y2)/d2)); 
end;

procedure readmatrix; 
var h:real;
begin
 for i:=0 to 10 do
  for j:=0 to 14 do
   begin
    h:=k+i/10*(df-k+l);
    kut:=j/14*2*pi;
    xl1[i,j]:=contur(h)*cos(kut+kut3);
    zl1[i,j]:=contur(h)*sin(kut+kut3)*cos(kut2)-(o-h)*sin(kut2); 
    yl1[i,j]:=contur(h)*sin(kut+kut3)*sin(kut2)+(o-h)*cos(kut2);
   end;
  for j:=0 to 14 do
   begin
    h:=l;
    kut:=j/14*2*pi;
    xl1[0,j]:=l*sin(alpha)/cos(alpha)*cos(kut+kut3);
    zl1[0,j]:=l*sin(alpha)/cos(alpha)*sin(kut+kut3)*cos(kut2)-(o-h)*sin(kut2); 
    yl1[0,j]:=l*sin(alpha)/cos(alpha)*sin(kut+kut3)*sin(kut2)+(o-h)*cos(kut2);
   end;  
end;
   


begin 
  readinfo;
  readmatrix;
  repeat
    event(km,xm,ym); 
    pen(2,20, 255, 0);
    brush(1,0,0,0);
    rectangle(-1,-1,1300,750);
    if (km=1) then 
     begin 
      key:=chr(xm); 
      if (key='W')or(key='w') then  zp:=zp+croc; 
      if (key='S')or(key='s') then  zp:=zp-croc; 
      if (key='D')or(key='d') then  xp:=xp+croc; 
      if (key='A')or(key='a') then  xp:=xp-croc; 
      if (key='Q')or(key='q') then  yp:=yp-croc; 
      if (key='E')or(key='e') then  yp:=yp+croc; 
      if (key='Z')or(key='z') then  fv:=fv-0.0000001; 
      if (key='X')or(key='x') then  fv:=fv+0.0000001; 
      if (key='T')or(key='t') then  begin kut2:=kut2+0.05; readmatrix; end;
      if (key='G')or(key='g') then  begin kut2:=kut2-0.05; readmatrix; end;
      if (key='Y')or(key='y') then  begin kut3:=kut3+0.05; readmatrix; end;
      if (key='H')or(key='h') then  begin kut3:=kut3-0.05; readmatrix; end;
      if (key='C')or(key='c') then  fvx:=fvx-0.000001; 
      if (key='v')or(key='V') then  fvx:=fvx+0.000001; 
      fvy:=fvx;
     end;
     for i:=0 to 9 do
       for j:=0 to 13 do
         begin
          line_3d(xl1[i,j],yl1[i,j],zl1[i,j],xl1[i,j+1],yl1[i,j+1],zl1[i,j+1]);
          line_3d(xl1[i,j],yl1[i,j],zl1[i,j],xl1[i+1,j],yl1[i+1,j],zl1[i+1,j]);  
         end;   
   until(key='L')or(key='l');
end. 
