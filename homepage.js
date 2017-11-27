window.addEventListener('DOMContentLoaded', function(e) {
    setInterval(function resizeIFrameToFitContent() {
        var iFrame = document.getElementById( 'iframe' );

        iFrame.width  = iFrame.contentWindow.document.body.scrollWidth;
        iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
    }, 500);
});