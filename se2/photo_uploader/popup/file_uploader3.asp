<% Response.CharSet = "utf-8" %> 

<!-- #INCLUDE virtual="/dbconn/dbconn.asp" -->
<!-- #INCLUDE virtual="/dbconn/function.asp" -->
<%

  Set uploadform = Server.CreateObject("DEXT.FileUpload")
  uploadform.CodePage = 65001
  uploadform.DefaultPath = "D:\home\ace-edu.or.kr\sub03\pds"
  uploadform.MaxFileLen = 10485760


  filename = uploadform("Filedata").FileName '새로 수정될 파일
  filepath = "D:\home\ace-edu.or.kr\sub03\pds\" & filename


  If uploadform("Filedata").FileLen > uploadform.MaxFileLen Then 

   %>

   <script>]

    alert("제한용량을 초과하였습니다. 10M이하의 이미지 자료만 업로드 하실 수 있습니다.");
    history.back();

   </script>

   <%


   dbconn.close
   set dbconn = nothing

   response.end

  end if


  idx = uploadform("idx")

  sql = "Select img from education_donation_application where comcode = '" & session("comcode") & "' and solution_name = '" & session("solution_name") & "' and idx = '" & idx & "' and user_id = '" & session("ed_id") & "'"
  set rs = Server.CreateObject("ADODB.RecordSet")
  rs.Open sql,dbconn, 1 , 1

  if rs.eof then
  else
   
   img = rs(0)

  end if

  rs.close
  set rs = nothing



  Set FSO = server.createobject("scripting.filesystemobject")


  if filename = "" then
  else

   uploadedfile = uploadform("Filedata").SaveAs("D:\home\ace-edu.or.kr\sub03\pds\" & filename, False) 
   set F = FSO.GetFile(uploadedfile)

   wt = uploadform("Filedata").ImageWidth

   F1 = F.Name



   if Not FSO.FileExists("D:\home\ace-edu.or.kr\sub03\pds\" & img) Then
   else 

    FSO.deleteFile "D:\home\ace-edu.or.kr\sub03\pds\" & img, true

   end if


  end if

  Set uploadform = nothing
  Set FSO = nothing





  dbconn.BeginTrans '트랜잭션 시작




  SQL = "UPDATE education_donation_application set img = '" & F1 & "' where comcode = '" & session("comcode") & "' and solution_name = '" & session("solution_name") & "' and idx = '" & idx & "' and user_id = '" & session("ed_id") & "'"
  dbconn.execute(SQL)


  if dbconn.errors.count = 0 then
     
   dbconn.CommitTrans

  else

   dbconn.RollbackTrans

  end if 

  dbconn.close
  set dbconn = nothing



%>

<script>

 opener.document.join_form.Picture.src = "/sub03/pds/<%=F1%>" ;
 opener.document.join_form.UploadPicture.value = "<%=F1%>" ;
 self.close() ;

</script>

