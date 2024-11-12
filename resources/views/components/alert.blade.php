@if (Session::has('status'))
    <div class="alert alert-success d-flex align-items-center p-5">
        <!--begin::Icon-->
        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">Tudo certo!</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span>{{ Session::get('status') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
@endif