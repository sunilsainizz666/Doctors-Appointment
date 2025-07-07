 <style>
   .modal-dialog.large {
    width: 80% !important;
    max-width: unset;
  }
  .modal-dialog.mid-large {
    width: 50% !important;
    max-width: unset;
  }
  /* Responsive modal improvements */
  @media (max-width: 768px) {
    .modal-dialog.large, .modal-dialog.mid-large {
      width: 95% !important;
    }
  }
 </style>
 <script>
 	// Initialize datepicker
 	$(function() {
 		$('.datepicker').datepicker({
 			format:"yyyy-mm-dd"
 		})
 	})
 	
 	// Show preloader
 	window.start_load = function(){
    if (!$('#preloader2').length) {
      $('body').prepend('<div id="preloader2"></div>');
    }
 	}
 
 	// Hide preloader
 	window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
 	}

 	// Show modal with AJAX content
 	window.uni_modal = function($title = '' , $url='',$size=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.error(err)
            alert("An error occurred while loading the modal.")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal .modal-dialog').attr('class', 'modal-dialog ' + $size)
                }else{
                    $('#uni_modal .modal-dialog').attr('class', 'modal-dialog modal-md')
                }
                $('#uni_modal').modal('show')
            }
            end_load()
        }
    })
}
 
 	// Show right-side modal with AJAX content
 	window.uni_modal_right = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.error(err)
            alert("An error occurred while loading the modal.")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal_right .modal-title').html($title)
                $('#uni_modal_right .modal-body').html(resp)
                
                $('#uni_modal_right').modal('show')
            }
            end_load()
        }
    })
}

 	// Show toast notification
 	window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      const toast = $('#alert_toast')
      toast.removeClass('bg-success')
           .removeClass('bg-danger')
           .removeClass('bg-info')
           .removeClass('bg-warning')

    if($bg == 'success')
      toast.addClass('bg-success')
    if($bg == 'danger')
      toast.addClass('bg-danger')
    if($bg == 'info')
      toast.addClass('bg-info')
    if($bg == 'warning')
      toast.addClass('bg-warning')
    toast.find('.toast-body').html($msg)
    toast.toast({delay:3000}).toast('show');
 	}
 
 	// Load cart item count
 	window.load_cart = function(){
    $.ajax({
      url:'admin/ajax.php?action=get_cart_count',
      success:function(resp){
        let count = parseInt(resp, 10);
        count = isNaN(count) || count < 0 ? 0 : count;
        $('.item_count').html(count)
      },
      error: function(err) {
        console.error('Failed to load cart count:', err);
      }
    })
 	}
 
 	// Login modal trigger
 	$(document).on('click', '#login_now', function(){
    uni_modal("LOGIN",'login.php')
 	})
 
 	// On document ready
 	$(document).ready(function(){
    load_cart()
 	})
 </script>
        <!-- Bootstrap core JS-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>