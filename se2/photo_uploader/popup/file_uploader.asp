<% Response.CharSet = "utf-8" %> 
<!--#include virtual="/admin/dbconn.html"-->
<!--#include virtual="/admin/function.html"-->
<%

  Set uploadform = Server.CreateObject("DEXT.FileUpload")
  uploadform.CodePage = 65001
  uploadform.DefaultPath = TempPath

  filename = uploadform("Filedata").FileName '새로 수정될 파일
  filepath = DataUploadPath & "\" & filename

%>

<!--#include virtual="/admin/UseStorageSpace.html"-->

<%

  Set FSO = server.createobject("scripting.filesystemobject")


  if filename = "" then
  else

   uploadedfile = uploadform("Filedata").SaveAs(DataUploadPath & "\" & SPECIALCHAR(filename), False) 
   set F = FSO.GetFile(uploadedfile)

   wt = uploadform("Filedata").ImageWidth

   F1 = F.Name

  end if

  Set uploadform = nothing
  Set FSO = nothing

  
%>


<input type="button" onclick="pasteHTML();" value="본문에 내용 넣기" />


<script>

var sHTML = "<img src='http://<%=Request.ServerVariables("http_host")%>/data/<%=F1%>' style='width:auto'>";
opener.nhn.husky.PopUpManager.setCallback(window,'PASTE_HTML',[sHTML]);
self.close() ;

</script>

