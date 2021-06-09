<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="mcinet">
		<meta name="Author" content="mcinet">
		<meta name="Keywords" content="mcinet"/>

		@include('master.head')
        

        <style>
            .hoverable-table .btn-primary{
                margin-left: 0;
                margin-right: 0;
                position: static;
            }
        </style>
    </head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>

		<!-- Sidebar -->
		@include('master.sidebar')

		<!-- main-content -->
		<div class="main-content app-content">
			@include('master.header')
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				        
                @yield('content')

				@include('master.footer')
            </div>
        </div>

        <script>
            $('document').ready(function () {
                $("#alert-message").fadeTo(2000, 500).slideUp(500, function () {
                    $('#alert-message').slideUp(500);
                });
            });
        </script>

            <!-- !!!WHAT ARE THOSE SCRIPTS !!!! -->

        <script>
            // for rhsd [envoyer]
            function CheckAll(className, elem) {
                var elements = document.getElementsByClassName(className);
                var l = elements.length;
                if (elem.checked) {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < l; i++) {
                        elements[i].checked = false;
                    }
                }
            }
        </script>

        {{-- <script>
            // Restricts input for the given textbox to the given inputFilter.
            window.onload=function() {
                function setInputFilter(textbox, inputFilter) {
                    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                        textbox.addEventListener(event, function() {
                            if (inputFilter(this.value)) {
                                this.oldValue = this.value;
                                this.oldSelectionStart = this.selectionStart;
                                this.oldSelectionEnd = this.selectionEnd;
                            } else if (this.hasOwnProperty("oldValue")) {
                                this.value = this.oldValue;
                                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                            } else {
                                this.value = "";
                            }
                        });
                    });
                }
            

            setInputFilter(document.getElementById("amount1"), function(value) {
                return /^\d*$/.test(value); });

            setInputFilter(document.getElementById("amount2"), function(value) {
                return /^\d*$/.test(value); });
            }
        </script> --}}
	</body>
</html>
