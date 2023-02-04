@extends('layouts.default')
@section('head_content')

<link rel="stylesheet" href="{{URL::asset('imageEditor/lib/style.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('imageEditor/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.3/fabric.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">

    <script src="{{ URL::asset('imageEditor/vendor/grapick.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('imageEditor/vendor/grapick.min.css') }}">

    <script src="{{ URL::asset('imageEditor/vendor/undo-redo-stack.js')}}"></script>

    <script src="{{ URL::asset('imageEditor/lib/core.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/toolbar.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/canvas.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/shapes.js')}}"></script>

    <script src="{{ URL::asset('imageEditor/lib/freeDrawSettings.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/canvasSettings.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/selectionSettings.js')}}"></script>

    <script src="{{ URL::asset('imageEditor/lib/drawingLine.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/drawingPath.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/drawingText.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/tip.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/upload.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/copyPaste.js')}}"></script>

    <script src="{{ URL::asset('imageEditor/lib/utils.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/zoom.js')}}"></script>
    <script src="{{ URL::asset('imageEditor/lib/saveInBrowser.js')}}"></script>
  <style>
    .canvas-container
    {
      
      background-image: url("{{URL::asset('product_upload')}}/{{$product->mockup}}") !important;
      background-repeat: no-repeat;
      background-size: contain;
      background-color: #fff;
    }
    .canvas-holder{
      height: 920px !important;
    }
  </style>

@endsection
@section('content')

<div class="container mt-4">
    
    <div class="row gx-2">
        <div class="col-md-12">
            <div class="card">
            <div class="card-footer d-grid gap-2">
                    <button class="btn btn-success" onclick="buyitem()">Proceed to Buy</button>
            </div>
            <div class="card-body">
                <div id="image-editor-container"></div>
                <!-- <canvas id="c" style="border:1px solid #ddd;"></canvas> -->
                <img src="" alt="" srcset="" />
                
                <!-- <div class="p-4">
                    <img src="https://placehold.co/600x400" id="my-image" class="img-fluid" alt="">
                </div> -->
            </div>
            </div>
        </div>
    </div>
</div>
<script>
  function buyitem()
  {
    console.log("Proceed to buy clicked");
    console.log(window.imgEditor);
    localStorage.setItem('image', JSON.stringify({
      "productid":"{{$product->id}}",
      "image": window.imgEditor.canvas.toDataURL()
    }));

    window.location.href = "{{route('product.buy',['id'=>$product->id])}}"
    console.log(localStorage.getItem('image').productid)
  }
    try {
  // define toolbar buttons to show
  // if this value is undefined or its length is 0, default toolbar buttons will be shown
  const buttons = [
    'select',
    'shapes',
    // 'draw',
    // 'line',
    // 'path',
    'textbox',
    'upload',
    'background',
    'undo',
    'redo',
    // 'save',
    'download',
    'clear'
  ];

  // define custom shapes
  // if this value is undefined or its length is 0, default shapes will be used
  const shapes = [
    `<svg viewBox="-10 -10 180 180" fill="none" stroke="none" stroke-linecap="square" stroke-miterlimit="10"><path stroke="#000000" stroke-width="8" stroke-linecap="butt" d="m0 0l25.742783 0l0 0l38.614174 0l90.09974 0l0 52.74803l0 0l0 22.6063l0 15.070862l-90.09974 0l-61.5304 52.813744l22.916225 -52.813744l-25.742783 0l0 -15.070862l0 -22.6063l0 0z" fill-rule="evenodd"></path></svg>`,
    `<svg viewBox="-10 -10 180 180" fill="none" stroke="none" stroke-linecap="square" stroke-miterlimit="10"><path stroke="#000000" stroke-width="8" stroke-linejoin="round" stroke-linecap="butt" d="m1.0425826 140.35696l25.78009 -49.87359l0 0c-30.142242 -17.309525 -35.62507 -47.05113 -12.666686 -68.71045c22.958385 -21.65932 66.84442 -28.147947 101.387596 -14.990329c34.543175 13.1576185 48.438576 41.655407 32.10183 65.83693c-16.336761 24.181526 -57.559166 36.132935 -95.233955 27.61071z" fill-rule="evenodd"></path></svg>`,
    `<svg viewBox="0 -5 100 100" x="0px" y="0px"><path fill="none" stroke="#000" stroke-width="8" d="M55.2785222,56.3408313 C51.3476874,61.3645942 45.2375557,64.5921788 38.3756345,64.5921788 C31.4568191,64.5921788 25.3023114,61.3108505 21.3754218,56.215501 C10.6371566,55.0276798 2.28426396,45.8997866 2.28426396,34.8156425 C2.28426396,27.0769445 6.35589452,20.2918241 12.4682429,16.4967409 C14.7287467,7.0339786 23.2203008,0 33.3502538,0 C38.667844,0 43.5339584,1.93827732 47.284264,5.14868458 C51.0345695,1.93827732 55.9006839,0 61.2182741,0 C73.0769771,0 82.6903553,9.6396345 82.6903553,21.5307263 C82.6903553,22.0787821 82.6699341,22.6220553 82.629813,23.1598225 C87.1459866,27.1069477 90,32.9175923 90,39.396648 C90,51.2877398 80.3866218,60.9273743 68.5279188,60.9273743 C63.5283115,60.9273743 58.9277995,59.2139774 55.2785222,56.3408313 L55.2785222,56.3408313 Z M4.79695431,82 C7.44623903,82 9.59390863,80.6668591 9.59390863,79.0223464 C9.59390863,77.3778337 7.44623903,76.0446927 4.79695431,76.0446927 C2.1476696,76.0446927 0,77.3778337 0,79.0223464 C0,80.6668591 2.1476696,82 4.79695431,82 Z M13.7055838,71.9217877 C18.4995275,71.9217877 22.3857868,69.4606044 22.3857868,66.424581 C22.3857868,63.3885576 18.4995275,60.9273743 13.7055838,60.9273743 C8.91163999,60.9273743 5.02538071,63.3885576 5.02538071,66.424581 C5.02538071,69.4606044 8.91163999,71.9217877 13.7055838,71.9217877 Z"></path></svg>`
  ];

  var imgEditor = new ImageEditor('#image-editor-container', buttons, [], "{{URL::asset('product_upload')}}/{{$product->mockup}}");

  let status = imgEditor.getCanvasJSON();
  imgEditor.setCanvasStatus(status);

} catch (_) {
  const browserWarning = document.createElement('div')
  browserWarning.innerHTML = '<p style="line-height: 26px; margin-top: 100px; font-size: 16px; color: #555">Yo{{ ur browser is out of date!<br/>Please update to a modern browser, for example:<a href="https://www.google.com/chrome/" target="_blank">Chrome</a>!</p>';

  browserWarning.setAttribute(
    'style',
    'position: fixed; z-index: 1000; width: 100%; height: 100%; top: 0; left: 0; background-color: #f9f9f9; text-align: center; color: #555;'
  )

  // check for flex and grid support
  let divGrid = document.createElement('div')
  divGrid.style['display'] = 'grid'
  let supportsGrid = divGrid.style['display'] === 'grid'

  let divFlex = document.createElement('div')
  divFlex.style['display'] = 'flex'
  let supportsFlex = divFlex.style['display'] === 'flex'

  if (!supportsGrid || !supportsFlex) {
    document.body.appendChild(browserWarning)
  }
}

</script>
<script>
// var canvas = new fabric.Canvas('c');
// canvas.setHeight(400);
// canvas.setWidth(600);
// canvas.setBackgroundImage('https://placehold.co/600x400')
// // create a rectangle with angle=45
// var imgElement = document.getElementById('my-image');
// var imgInstance = new fabric.Image(imgElement, {
//   left: 100,
//   top: 100,
//   angle: 30,
//   opacity: 0.85
// });
// canvas.add(imgInstance);

</script>

@stop