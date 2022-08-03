<script src="/panel/js/jquery-3.4.1.min.js"></script>
<script src="/panel/js/js.js?v={{uniqid()}}"></script>
<script src="/js/jquery.toast.min.js"></script>
{{--ckeditor--}}

@if(auth()->user()->hasAnyPermission(
[\ali\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN,
\ali\RolePermissions\Models\Permission::PERMISSION_TEACH]))
    <script src="/assets/ckeditor_4/ckeditor/ckeditor.js"></script>

@endif


<script>

    /*****************************start ckeditor js*/

    // CKEDITOR.replace('body');
    // CKEDITOR.replace('body', {
    //     language: 'fa'
    // })


    @if(auth()->user()->hasAnyPermission(
    [\ali\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN,
    \ali\RolePermissions\Models\Permission::PERMISSION_TEACH]))

    CKEDITOR.replace('body',
        {
            filebrowserImageBrowseUrl: '/file-manager/ckeditor',
            language: 'fa'
        });

    @endif


    /*****************************end ckeditor js*/

    /*****************************start file manager js*/

    document.addEventListener("DOMContentLoaded", function () {

        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        /*remove slash from if be in first character*/
        var $url = $url.substring(1);

        document.getElementById('image_label').value = $url;
    }


    /*****************************end file manager js*/






    @include("Common::layouts.feedbacks")
</script>


@yield('js')



