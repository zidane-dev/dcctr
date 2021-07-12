<div id="data_view" class="card mg-b-20 text-center">
    <div class="card-header">
        <h3>@lang('parametre.tbl_de_bord')</h3>
    </div>
    <div class="card-body" height="auto">
        <iframe
        src={!! $frame !!}
        scrolling="auto"
        frameborder="0"
        width="100%"
        height="1600"
        onload="resizeIframe(this)"
        allowtransparency
    ></iframe>
    </div>
</div>