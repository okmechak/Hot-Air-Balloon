Program KULIA; 
Var 
   r,l,vk,vc,alpha,v,o,k,ad,bc,dc,ab,d,c,os,f,bf,df:real; 
   xm,ym,km,n:integer; 
   file:text;

Function xekr(x1:real):integer; {dobre}
 Begin 
  xekr:=round(x1*60+5); 
 end; 

Function yekr(y1:real):integer;  {dobre}
 Begin 
  yekr:=round(-y1*60+240); 
 end; 

Function s(x2:real;n:integer):real; {dobre}
 Var 
   c:real; 
   i:integer; 
 Begin 
  c:=1; 
  For i:=1 to n do 
    c:=c*x2; 
  s:=c; 
 end; 

Procedure che; {dobre}
 Begin 
  brush(0,255,255,255);
  pen(1,4,5,6);
  Rectangle(0,0,1000,20); 
  Rectangle(0,20,1000,40); 
  Rectangle(0,40,1000,60);
  If xm<=1000 then
   Begin
    If ym<20 then  r:=xm/100; 
    If (ym>=20)and(ym<40) then  alpha:=xm/700; 
    If (ym>=40)and(ym<60) then  V:=xm/1.5;    
   end; 
   MoveTo(1000,3); 
   WriteLn('R=',r:5:3); 
   MoveTo(1000,23); 
   WriteLn('Alpha=',alpha:5:5,' A0D'); 
   MoveTo(1000,43);
   WriteLn('V=',v:5:3); 
 end; 

Function tan(a:real):real; {dobre}
 Begin 
  tan:=sin(a)/cos(a); 
 end; 
 
Procedure kulia; {dobre}
 Begin 
  Pen(3,255, 0, 0);
  brush(0,255,255,255);
  Ellipse(xekr(o-r),yekr(r),xekr(o+r),yekr(-r));   
  MoveTo(xekr(l),yekr(l*tan(alpha))); 
  WriteLn('A'); 
  MoveTo(xekr(k),yekr(k*tan(alpha))); 
  WriteLn('B'); 
  MoveTo(xekr(l),yekr(0)); 
  WriteLn('D'); 
  MoveTo(xekr(k),yekr(0)); 
  WriteLn('C'); 
  MoveTo(xekr(o),yekr(0)); 
  WriteLn('O"'); 
  MoveTo(xekr(o+r),yekr(0)); 
  WriteLn('F'); 
  Pen(3, 255, 128, 64);
  Line(xekr(l),yekr(l*tan(alpha)),xekr(k),yekr(k*tan(alpha))); 
  Line(xekr(l),yekr(-l*tan(alpha)),xekr(k),yekr(-k*tan(alpha))); 
  Line(xekr(l),yekr(l*tan(alpha)),xekr(l),yekr(-l*tan(alpha))); 
  Line(xekr(k),yekr(k*tan(alpha)),xekr(k),yekr(-k*tan(alpha))); 
 end; 

Procedure koord_sitka; {dobre}
 Begin 
  Pen(1,0,0,0);
  Line(0,240,1000,240); 
  Line(5,0,5,700); 
  MoveTo(31,241);
  WriteLn('O');
  moveto(31,460);
  writeln('Rozgortka X ',n);
  line(0,590,1000,590);
  line(1000,0,1000,800);
 end; 

 
Procedure rozgortka;
 Var j,cv:integer;
      f:real;
 Begin
  Pen(1,0, 255, 0);
  MoveTo(xekr(0),yekr(0)+400);
  cv:=10;
  For j:=0 to cv do 
   Begin
    f:=j/cv*r*(alpha+pi/2);
    LineTo(xekr(f),yekr(pi*r*sin(f/r)/n)+350);
   end; 
  MoveTo(xekr(0),yekr(0)+350);
  For j:=0 to cv do 
   Begin
    f:=j/cv*r*(alpha+pi/2);
    LineTo(xekr(f),yekr(-pi*r*sin(f/r)/n)+350);
    end;
  For j:=0 to cv do 
   Begin
    f:=j/cv*r*(alpha+pi/2);
    Line(xekr(f),yekr(0)+350,xekr(f),yekr(-pi*r*sin(f/r)/n)+350);
    writeln(j);
    end;  
  for j:=0 to cv do 
   begin
    f:=j/cv*r*(alpha+pi/2);
    moveto(1000,300+15*j);
    writeln(j,')  x=',f:2:3,'  y=',pi*r*sin(f/r)/n:2:3);
   end;    
  Line(xekr(r*(alpha+pi/2)),yekr(pi*r*sin(alpha+pi/2)/n)+350, xekr(r*(alpha+pi/2)+(k-l)/cos(alpha)),yekr(pi*ad/n)+350);
  Line(xekr(r*(alpha+pi/2)),yekr(-pi*r*sin(alpha+pi/2)/n)+350,xekr(r*(alpha+pi/2)+(k-l)/cos(alpha)),yekr(-pi*ad/n)+350);
  Line(xekr(r*(alpha+pi/2)),yekr(pi*r*sin(alpha+pi/2)/n)+350,xekr(r*(alpha+pi/2)),yekr(-pi*r*sin(alpha+pi/2)/n)+350);
  Line(xekr(r*(alpha+pi/2)+(k-l)/cos(alpha)),yekr(pi*ad/n)+350,xekr(r*(alpha+pi/2)+(k-l)/cos(alpha)),yekr(-pi*ad/n)+350);
  moveto(xekr(r*(alpha+pi/2))+1,yekr(pi*r*sin(alpha+pi/2)/n)+351);
  Writeln('A');
  moveto(xekr(r*(alpha+pi/2)+(k-l)/cos(alpha))+1,yekr(pi*ad/n)+345);
  writeln('B');
  moveto(xekr(0)+1,yekr(0)+351);
  writeln('D');
  moveto(xekr(r*(alpha+pi/2))+1,yekr(0)+351);
  writeln('E');
  moveto(xekr(r*(alpha+pi/2)+(k-l)/cos(alpha))+1,yekr(0)+349);
  writeln('S');
 end;
 
 
Procedure information;
 Begin
  o:=r/sin(alpha); 
  k:=r/tan(alpha)*cos(alpha); 
  vk:=pi*s(r,3)*(2/3+sin(alpha)-s(sin(alpha),3)/3); 
  If s(k,3)-(v-vk)/sqr(tan(alpha))/pi*3>0 then
   Begin
    l:=exp(1/3*ln(abs(s(k,3)-(v-vk)/sqr(tan(alpha))/pi*3))); 
    vc:=pi*sqr(tan(alpha))/3*(s(r*sqr(cos(alpha))/sin(alpha),3)-s(l,3));                
   end
  else 
   Begin 
    MoveTo(600,300);
    WriteLn('error'); 
   end;
 
  MoveTo(1000,63);
  AD:=l*tan(alpha);
  WriteLn('AD=',AD:5:3);
  MoveTo(1000,83);
  BC:=k*tan(alpha);
  WriteLn('BC=',BC:5:3);
  MoveTo(1000,103);
  AB:=(K-l)/cos(alpha);
  WriteLn('AB=',AB:5:3);
  MoveTo(1000,123);
  WriteLn('DC=',k-l:5:3);
  MoveTo(1000,143);
  BF:=r*(alpha+pi/2);
  WriteLn('BF(dyga)=',bf:5:3);
  MoveTo(1000,163);
  DF:=o+r-l;
  WriteLn('DF=',df:5:3);
  MoveTo(1000,183);
  WriteLn('D=',l:5:3);
  moveto(1000,203);
  writeln('S(poverhni)=',2*pi*r*r*(1-cos(pi/2+alpha))+pi*ab*(ad+bc):4:3);
  moveto(1000,243);
  writeln('DS=',bf+ab:5:3);
  moveto(1000,263);
  writeln('ES=AB=',AB:4:3);
  moveto(1000,283);
  writeln('BS=',l*tan(alpha)*pi/n:4:3);
 end; 
 
procedure writetofile;
 begin
  
  writeln(file,R);
  writeln(file,l);
  writeln(file,alpha);
  writeln(file,df); 
  writeln(file,o);
  writeln(file,k);
  writeln(file,V);
 end;    
                         
 Begin 
  n:=14;
  r:=5.18; 
  v:=650; 
  l:=1;
  alpha:=0.53444; 
  ym:=999; 
  Font(8,0,400);
  Repeat
    Event(km,xm,ym); 
    Brush(1,  255, 255, 255); 
    Rectangle(0,0,1300,700); 
    Pen(4,255, 255, 0);
    Line(xekr(-0.2),yekr(0),xekr(-0.2),yekr(1.5));  
    che;
    information;
    kulia;
    rozgortka;      
    koord_sitka;  
  until (ym>=640); 
  assign(file,'C:\data.txt');
  rewrite(file);
  Writetofile;
  close(file);
 end.
