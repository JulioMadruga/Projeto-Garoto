function calc_kg(vd){
    
    i=0;
    somar = 0;
    somar_valor = 0;
    somar_tri = 0;
    somar_baton = 0;
    somar_tab = 0;
	   
      
    while(i<vd){
         var serenata = parseInt(document.getElementById('serenata'+i).value)*9;
         var candybar = parseInt(document.getElementById('candybar'+i).value)*7.2;
         var talento_mini = parseInt(document.getElementById('talento_mini'+i).value)*6.75;
         var talento= parseInt(document.getElementById('talento'+i).value)*9.6;
         var baton = parseInt(document.getElementById('baton'+i).value)*15.36;
         var cobertura_kg = parseInt(document.getElementById('cobertura_kg'+i).value)*12;
         var cobertura_500g = parseInt(document.getElementById('cobertura_500g'+i).value)*10;
         var cobertura_2kg = parseInt(document.getElementById('cobertura_2kg'+i).value)*10.5;
         var pastilha = parseInt(document.getElementById('pastilha'+i).value)*16.32;
         var baton_tab = parseInt(document.getElementById('baton_tab'+i).value)*5.4;
         var tabletes = parseInt(document.getElementById('tabletes'+i).value)*7.2;
         var sortido = parseInt(document.getElementById('sortido'+i).value)*9;
         var tri = parseInt(document.getElementById('trimarca'+i).value);
         var mbaton = parseInt(document.getElementById('meta_baton'+i).value);
         var jumbo = parseInt(document.getElementById('jumbo'+i).value);
         
         
         
  tot = serenata + candybar + talento_mini + talento + baton + cobertura_kg + cobertura_500g + cobertura_2kg + pastilha + baton_tab + tabletes + sortido;
                   
             document.getElementById('kg'+i).value =parseFloat(tot).toFixed(2);
             valor = parseFloat( tot )* 31.5;
            document.getElementById('valor'+i).value= parseFloat(valor).toFixed(2);
             
          
          
         somar = somar + tot;
         
               
         document.getElementById('total_kg').value = parseFloat(somar).toFixed(2).replace(".", ",");
         
         somar_valor = somar_valor + valor;
         
               
               
         document.getElementById('total_valor').value ="R$ "+parseFloat(somar_valor).toFixed(2).replace(".", ",");
         
         
         somar_tri = somar_tri + tri;
         
         document.getElementById('total_tri').value = somar_tri;
         
         
        somar_baton = somar_baton + mbaton;
         
         document.getElementById('total_baton').value = somar_baton;
         
         
         somar_tab = somar_tab + jumbo;
         
         document.getElementById('total_jumbo').value = somar_tab;
         
          
         
         
        i++;  
         }; 




     }

function tri(){
    
    var meta = parseInt(document.getElementById('tri').innerText);
    var result= parseInt(document.getElementById('tri_result').innerText);
    
    
    dif = ((result/meta)*100).toFixed(0);
    
 if(dif>100){
    
   difn = "100%";
  
    document.getElementById('graftri').style.width = difn;
    document.getElementById('graftri').innerText = difn+"  Atingido";
    
} else{
    difn = dif.toString();
document.getElementById('graftri').style.width = difn+"%";
document.getElementById('graftri').innerText = difn+"%"+"  Atingido";
}
}

function bat(){
    
    var meta = parseInt(document.getElementById('baton').innerText);
    var result= parseInt(document.getElementById('baton_result').innerText);
    
    
    dif = ((result/meta)*100).toFixed(0);
    
 if(dif>100){
    
   difn = "100%";
  
    document.getElementById('grafbaton').style.width = difn;
    document.getElementById('grafbaton').innerText = difn+"  Atingido";
    
} else{
    difn = dif.toString();
document.getElementById('grafbaton').style.width = difn+"%";
document.getElementById('grafbaton').innerText = difn+"%"+"  Atingido";
}

}

function kg(){
    
    var meta = document.getElementById('jumbo').innerText;
    var result= document.getElementById('jumbo_result').innerText;
    
    metavalor =  parseFloat(meta.replace("R$","").replace(".","").replace(",","."));
    resultvalor =  parseFloat(result.replace("R$","").replace(".","").replace(",","."));
    
       
    difkg = ((resultvalor/metavalor)*100).toFixed(0);
    
    
   if (difkg>100){
    
   difnkg = "100%";
  
    document.getElementById('grafjumbo').style.width = difnkg;
    document.getElementById('grafjumbo').innerText = difnkg+"  Atingido";
    
} else{
    difnkg = difkg.toString();
  
document.getElementById('grafjumbo').style.width = difnkg+"%";
document.getElementById('grafjumbo').innerText = difnkg+"%"+"  Atingido";
}
}

function valor(){
    
    var meta = document.getElementById('valor').innerText;
    var result=document.getElementById('valor_realizado').innerText;   
    
    metavalor =  parseFloat(meta.replace("R$","").replace(".","").replace(",","."));
    resultvalor =  parseFloat(result.replace("R$","").replace(".","").replace(",","."));
    
    difv = ((resultvalor/metavalor)*100).toFixed(0);

   if (difv>100){
    
   difnv= "100%";
  
    document.getElementById('grafvalor').style.width = difnv;
    document.getElementById('grafvalor').innerText = difnv+"  Atingido";
    
} else{
    difnv = difv.toString();
  
document.getElementById('grafvalor').style.width = difnv+"%";
document.getElementById('grafvalor').innerText = difnv+"%"+"  Atingido";
}
}


function login(){
    
    var tipo = document.getElementById('tipo').value; 
    
    document.getElementById('acao').value = tipo;
    
}

function verifica(){
    var tabela = document.getElementById('tabela');    
    var linhas = tabela.getElementsByTagName('tr');     
    cont = linhas.length -2;
       
    i=0;
   
    
   while(i<cont){
    
     var valor = document.getElementById('valor'+i).innerText; 
     metavalor =  parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
  // alert(metavalor);
    
    if (metavalor<0){
    document.getElementById('vendas'+i).style.color = "rgb(255, 0, 0)";
    document.getElementById('vendas'+i).style.fontWeight = "bold";
   
   
    } 
    if(i % 2 == 0){
        document.getElementById('vendas'+i).style.background = "#BED1D6";
        
        
    } i++;
    }

}
    
 
function calc_metatri(){
    
    var tabela = document.getElementById('tabela');    
    var linhas = tabela.getElementsByTagName('tr');     
    cont = linhas.length -1;
   
   i=0;
   soma=0;
    
    while(i<cont){
         var total = parseInt(document.getElementById('meta'+i).innerText);
    
    soma = soma + total;
    i++;
}
   document.getElementById('totalmetatri').innerText = soma;
   
   totaltri = parseInt(document.getElementById('totaltri').innerText);
   
   total = soma - totaltri;
   
   document.getElementById('diftri').innerText = total
   

   
   
}