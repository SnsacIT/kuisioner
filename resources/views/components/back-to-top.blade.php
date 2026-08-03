<a href="#" class="back-to-top bg-sns shadow" aria-label="Back to top">
  <i class="bi bi-arrow-up-short"></i>
</a>

@push('scripts')
  <script>
    $(document).ready(function () {
      var backToTop = $('.back-to-top');
      var appMain = $('.app-main');

      appMain.on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var maxScroll = 300;
        
        if (scrollTop > 0) {
          var opacity = Math.min(scrollTop / maxScroll, 1);
          backToTop.css('opacity', opacity);
          
          if (opacity > 0.1) {
            backToTop.css('pointer-events', 'auto');
          } else {
            backToTop.css('pointer-events', 'none');
          }
        } else {
          backToTop.css('opacity', 0);
          backToTop.css('pointer-events', 'none');
        }
      });

      backToTop.on('click', function (e) {
        e.preventDefault();
        appMain.animate({
          scrollTop: 0
        }, 600, 'swing');
        return false;
      });
    });
  </script>
@endpush

<style>
  .back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 996;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border: 2px solid rgba(255, 255, 255, 0.3);
    
    transition: opacity 0.15s ease-out,
                transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.3s ease,
                background-color 0.3s ease,
                border-color 0.3s ease;
    
    opacity: 0;
    pointer-events: none;
  }

  .back-to-top i {
    font-size: 28px;
    color: #ffffff;
    line-height: 0;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .back-to-top:hover {
    background-color: #000080cc !important;
    transform: translateY(-5px) scale(1.08);
    box-shadow: 0 10px 25px rgba(0, 0, 128, 0.5) !important;
    border-color: rgba(255, 255, 255, 0.5);
  }

  .back-to-top:hover i {
    transform: translateY(-3px);
  }

  .back-to-top:active {
    transform: translateY(-3px) scale(1.05);
    transition-duration: 0.1s;
  }

  @media (max-width: 768px) {
    .back-to-top {
      bottom: 20px;
      right: 20px;
      width: 45px;
      height: 45px;
    }

    .back-to-top i {
      font-size: 24px;
    }
  }

  .back-to-top:focus {
    outline: 3px solid rgba(255, 255, 255, 0.6);
    outline-offset: 3px;
  }

  .back-to-top:focus-visible {
    outline: 3px solid rgba(255, 255, 255, 0.8);
    outline-offset: 3px;
  }
</style>