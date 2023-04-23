<!DOCTYPE html>
<html class="no-js" lang="ar">
  <head>
    <title>@lang('site.site_title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="description">
    <meta name="Sard" content="sard">
    <meta name="robots" content="index">
    <!-- ******* FavIcon ******* //-->
    <link rel="icon" href="{{asset('assets')}}/imgs/favicon.png" type="image/x-icon">
    <!-- ******* CSS File ******* //-->
    <!--link(rel="stylesheet", href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous")-->
    <!--in case of ar only-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">

      @yield('styles')

    @livewireStyles

  </head>
  <body class="home-page" x-data x-on:saved="toastr.success($event.detail.message);">>
    <div class="toggled" id="wrapper">
      <!--Sidebar-->
      <div id="sidebar-wrapper">
        <div class="sidebar-nav">
          <div class="logo-wrap"><img src="{{asset('assets')}}/imgs/home/logo.svg" alt=""></div>
          <ul>
            <li><a href="{{route('admin.home')}}">@lang('home')</a></li>
            <li class="accordion">
              <div class="accordion-header"><a class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse-m">إدارة العاملين والموظفين</a></div>
              <div class="accordion-collapse collapse" id="collapse-m">
                <ul>
                  <li><a href="#"> البيانات  الأساسية</a></li>
                  <li><a href="#">بيانات هوية / إقامة الموظف</a></li>
                  <li class="active"><a href="#">معلومات جواز سفر</a></li>
                  <li><a href="#">الفحص المهني للموظف</a></li>
                  <li><a href="#">عقد الموظف</a></li>
                  <li><a href="#">بطاقات الموظف</a></li>
                  <li><a href="#">أجازات الموظف</a></li>
                  <li><a href="#">بيانات التواصل في حال الأجازة</a></li>
                  <li><a href="#">تعريفات الموظف</a></li>
                  <li><a href="#">ملفات الموظف</a></li>
                  <li><a href="#">الملاحظات والتنبيهات</a></li>
                </ul>
              </div>
            </li>
            <li class="accordion">
              <div class="accordion-header">
                  <a class="accordion-button" data-bs-toggle="collapse" data-bs-target="#company-affairs">شؤون الشركة</a></div>
              <div class="accordion-collapse collapse" id="company-affairs">
                <ul>
                  <li><a href="{{route('admin.document_type.index')}}"> @lang('site.document_types')</a></li>
                  <li><a href="{{route('admin.document.index')}}">@lang('site.company_documents')</a></li>

                  <li><a href="{{route('admin.employee_type.index')}}"> @lang('site.employee_types')</a></li>
                  <li><a href="{{route('admin.department.index')}}"> @lang('site.departments')</a></li>
                  <li><a href="{{route('admin.nationality.index')}}"> @lang('site.nationalities')</a></li>
                </ul>
              </div>
            </li>
            <li><a href="#">التقارير</a></li>
            <li><a href="{{route('admin.user.index')}}">مستخدمي النظام</a></li>
            <li><a href="#">التنبيهات</a></li>
          </ul>
          <div class="log-out"><a href="#"><img src="{{asset('assets')}}/imgs/home/sign-out.svg" alt="">خروج</a></div>
        </div>
      </div>
      <div id="page-content-wrapper">
        <!-- Main Content-->
        <main class="main-content">
          <!--header-->

          <div class="head-div">
            <div class="container-fluid">
              <div class="flex-div">
                <div><a href="#menu-toggle" id="menu-toggle"><img src="{{asset('assets')}}/imgs/home/menu.svg" alt=""></a>
                  <h2>{{isset($page_title)? $page_title : ''}}</h2>
                </div>
                <div class="head-items">
                  <div class="dropdown">
                    <button class="dropdown-toggle notifi" data-bs-toggle="dropdown"><img src="{{asset('assets')}}/imgs/home/bell.svg" alt="">
                      <div class="n-num">12</div>
                    </button>
                    <div class="dropdown-menu">
                                <div class="dropdown-item">
                                  <h6>عنوان الإشعار<span class="end grey">Sep 19</span></h6>
                                  <p class="grey">تفاصيل مختصرة عن التنبيه تفاصيل مختصرة  </p>
                                </div>
                                <div class="dropdown-item">
                                  <h6>عنوان الإشعار<span class="end grey">Sep 19</span></h6>
                                  <p class="grey">تفاصيل مختصرة عن التنبيه تفاصيل مختصرة  </p>
                                </div>
                                <div class="dropdown-item">
                                  <h6>عنوان الإشعار<span class="end grey">Sep 19</span></h6>
                                  <p class="grey">تفاصيل مختصرة عن التنبيه تفاصيل مختصرة  </p>
                                </div>
                      <div class="drop-foot text-center"><a class="orange" href="#">مشاهدة  كل الإشعارات</a></div>
                    </div>
                  </div>
                  <div class="profile-det">
                      <img src="{{auth()->user()->avatar_url}}">
                    <div class="text-det">
                      <h6>{{auth()->user()->name}}</h6>
                      <p class="grey">{{auth()->user()->email}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- [END HEADER] -->

            @yield('content')

          <!-- [START FOOTER]------------------------>
        </main>
        <!-- End Main Content-->
        <!-- Main footer-->
        <footer class="main-footer">
          <div class="container"></div>
        </footer>
        <!-- End Main footer-->
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src='{{asset('assets/jquery-confirm/js/jquery-confirm.js')}}'></script>
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('assets')}}/js/functions.js"></script>
    <script src='{{asset('plugins/select2/select2-full.js')}}'></script>
    <script src='{{asset('plugins/datepicker/bootstrap-datepicker.js')}}'></script>
    <script>


        // $('.datepicker').datepicker({
        //     format:'yyyy-mm-dd'
        // });

        // $('.datepicker').on('changeDate',function(e){
        //     e.target.value=e.date.toISOString().split('T')[0];
        //     e.target.dispatchEvent(new Event('change'));
        // });

        // $("select.form-control").select2( {
        //         theme: "bootstrap",
        //         maximumSelectionSize: 6,
        //         containerCssClass: ':all:',
        //         width:'resolve',
        //         dir:'rtl'
        // });/*select2*/
        $(document).ready(function(){
            window.resetForm = function(element){
                $(element).parents('form').find('select').each(function(){
                    $(this).val(0).trigger("updated");
                    console.log($(this).val());
                });
                $(element).parents('form').find('input').each(function(){
                    if(!$(this).hasClass('btn')){
                        $(this).val('');
                    }

                });
            }


        });
    </script>
    <script src='js/app.js'></script>
    @stack('scripts')
    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
  </body>
</html>
