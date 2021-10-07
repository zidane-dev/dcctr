<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/403.css')}}" />
    <title>Unauthorized</title>
</head>
<body>
    
<div class="ghost">
  
    <div class="ghost--navbar"></div>
      <div class="ghost--columns">
        <div class="ghost--column">
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
        </div>
        <div class="ghost--column">
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
        </div>
        <div class="ghost--column">
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
          <div class="code"></div>
        </div>
        
      </div>
      
      <div class="ghost--main mx-auto">
        <div class="code text-center pt-1" style="color:rgb(221, 221, 221)">ACCESS : DENIED</div>
        <div class="code mx-auto"></div>
        <div class="my-4">
          <p class="text-center mb-2" style="color:white">
            @lang('roles.403_message')
          </p>
          <a href="{{route('dashboard.index')}}">
            <button class="btn btn-md btn-warning w-100 py-3" >
              <h4>Go Back</h4>
            </button>
          </a>
        </div>
        <div class="code mx-auto"></div>
      </div>
      
      
    
    </div>
    
    <h1 class="police-tape police-tape--1">
      &nbsp;&nbsp;&nbsp;&nbsp;غلط: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erreur: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erreur: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;خطأ: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erreur: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erreur: 403
    </h1>
    <h1 class="police-tape police-tape--2">Interdit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ممنوع&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interdit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ممنوع&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
  
</body>
</html>