<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyPro | Platinum</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('assets/StudyProLogo.png') }}" />
    {{-- styles --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/stepper.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- DataTable --}}
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

    <style>
        .form-section {
            display: none;
        }

        .form-section.current {
            display: inline;
        }

        .parsley-errors-list {
            color: red;
        }

        /*--------------------------------------------------------------
# Profie Page
--------------------------------------------------------------*/
        .profile-card img {
            max-width: 120px;
        }

        .profile-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c384e;
            margin: 10px 0 0 0;
        }

        .profile-card h3 {
            font-size: 18px;
        }

        .profile-card .social-links a {
            font-size: 20px;
            display: inline-block;
            color: rgba(1, 41, 112, 0.5);
            line-height: 0;
            margin-right: 10px;
            transition: 0.3s;
        }

        .profile-card .social-links a:hover {
            color: #012970;
        }

        .profile-overview .row {
            margin-bottom: 20px;
            font-size: 15px;
        }

        .profile-overview .card-title {
            color: #012970;
        }

        .profile-overview .label {
            font-weight: 600;
            color: rgba(1, 41, 112, 0.6);
        }
    </style>

</head>

<body>
    <div id="wrapper">
        <x-navbar />
        <main id="main" class="main">
            @yield('container')
        </main>
    </div>

    {{-- Document Ready --}}
    <script>
        $(document).ready(function() {
            $('#myTable').dataTable({
                responsive: true
            });

            $("#imagePreview").hide();
            $("#PI_File").on("change",function(e){
                var arrTemp = this.value.split('\\');
                document.getElementById("imagePreview").value = arrTemp[arrTemp.length - 1];
                let idImgShow = 'imagePreview';
                if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                $('#' + idImgShow + '').attr('src', e.target.result);
                $('#' + idImgShow + '').show();
            }

                reader.readAsDataURL(this.files[0]);
                $("#imagePreview").show();
            }
            })

        });

        //addMoreButn
        var i = 0;
        $('#addMore').click(function() {
            ++i;
            $('.add-more').append(
                `
                <div class="row col-12 mb-2">
                    <div class="col-11">
                        <input class="form-control" type="file" id="RP_File_[` + i + `]" name="RP_File_[` + i + `]" required>
                    </div>
                    <div class="col-1">
                        <button id="removeMore" name="removeMore" type="button" class=" btn btn-danger ml-5 remove-table-row">
                            X
                        </button>
                    </div>
                </div>
                `
            )
        })

        $(document).on('click', '.remove-table-row', function() {
            $(this).closest('.col-12').remove();
        })


        //Form Section function
        $(function() {
            var $sections = $('.form-section');

            function navigateTo(index) {

                $sections.removeClass('current').eq(index).addClass('current');

                $('.form-navigation .previous').toggle(index > 0);
                var atTheEnd = index >= $sections.length - 1;
                $('.form-navigation .next').toggle(!atTheEnd);
                $('.form-navigation [Type=submit]').toggle(atTheEnd);
                $('.form-navigation .addMore').toggle(index == 1);

                const step = document.querySelector('.step' + index);



            }

            function curIndex() {

                return $sections.index($sections.filter('.current'));
            }

            $('.form-navigation .previous').click(function() {
                navigateTo(curIndex() - 1);
            });

            $('.form-navigation .next').click(function() {
                $('.expert-form').parsley().whenValidate({
                    group: 'block-' + curIndex()
                }).done(function() {
                    navigateTo(curIndex() + 1);
                });

            });

            $sections.each(function(index, section) {
                $(section).find(':input').attr('data-parsley-group', 'block-' + index);
            });
            navigateTo(0);
        });
    </script>

</body>

</html>
