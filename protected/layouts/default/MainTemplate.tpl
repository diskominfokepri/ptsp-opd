<!DOCTYPE html>
<html lang="id">
<com:THead>     
    
</com:THead>
<body>  

<com:TForm Attributes.role="form">   
<com:TOutputCache>
    <com:TClientScript PradoScripts="bootstrap,effects" />
</com:TOutputCache>    

<com:TContentPlaceHolder ID="maincontent" />
<h2>Ini Halaman OPD</h2>
	
<com:TPanel Visible="<%=$this->User->isGuest==false%>">
	<com:TActiveCustomButton ID="btnLogout" CssClass="btn btn-primary btn-block" ValidationGroup="userlogout" Onclick="doLogout">                            
			<prop:Text>				
				Logout
			</prop:Text>
			<prop:ClientSide.OnPreDispatch>
				$('#<%=$this->btnLogout->ClientId%>').prop('disabled',true);						
			</prop:ClientSide.OnPreDispatch>
			<prop:ClientSide.OnLoading>
				$('#<%=$this->btnLogout->ClientId%>').prop('disabled',true);									                                    
			</prop:ClientSide.OnLoading>
			<prop:ClientSide.onComplete>                                    
				$('#<%=$this->btnLogout->ClientId%>').prop('disabled',false);	                       
			</prop:ClientSide.OnComplete>
		</com:TActiveCustomButton>
</com:TPanel>       
<com:TJavascriptLogger ID="loggerJS" />
</com:TForm>

</body>
</html>
