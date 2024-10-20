<!-- BEGIN: Footer-->
<footer class="footer footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0">
    <span class="float-md-start d-block d-md-inline-block mt-25">
      {!! $company->copy_right_text !!}
    </span>
    @if ($user->is_admin)
      <a href="{{ asset('pdf/Remapdash T&C.pdf') }}" style="float: right" target="_blank" rel="noopener noreferrer">Terms & Conditions</a>
    @endif
  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
