<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>TinyPNG Test</title>
 
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="/dropzone/dropzone.css">
</head><!--/head-->
<style>
    .image img{
        width:400px;
        height: auto;
    }
</style>
<body>

    <section>

        <div class="container">
        {!! var_dump($files1) !!}
        @foreach($files1 as $files)
          @if($files != '.' && $files != '..')
          <img src="{!! $dir.'/'.$files !!}" height="100px">
          @endif
        @endforeach
        </div>
    </section>
    
    <footer id="footer"><!--Footer-->
      
        
    </footer><!--/Footer-->
  
   

</body>
</html>