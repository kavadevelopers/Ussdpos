<script type="text/javascript">
	$(document).ready(function(){
		$("*").dblclick(function(e){
            if (e.target.tagName.toLowerCase() == "td") {

            }else{
                e.preventDefault();
                return false;
            }
		});

		$('.table-dt').DataTable({
            "dom": "<'row'<'col-md-6'l><'col-md-6'f>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            order : [],
            "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        });

        $(document).on('click','.btn-delete', function(event){
			if(confirm('Are you sure you want to delete this?')){
				return true;
			}
			return false;
		});

        $(document).on('click','.btn-status', function(event){
			if(confirm('Are you sure you want to change status?')){
				return true;
			}
			return false;
		});

		$(document).on('click','.photo-swipe', function(event){
            var stringAr = $(this).data('photoswipe').split('+');
            var items = [];
            for(var i = 0; i < stringAr.length; i++) { 
                items.push({
                    src     : stringAr[i].split('=')[0], 
                    w       : parseInt(stringAr[i].split('=')[1].split(',')[0]),
                    h       : parseInt(stringAr[i].split('=')[1].split(',')[1])
                });
            }

            myConsole(items);
            var pswpElement = document.querySelectorAll('.pswp')[0];
            var options = {
                // optionName: 'option value'
                // for example:
                shareEl:true,
                index: 0 // start at first slide
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        });

        $(document).on('click','.btnChangeAgentPassword', function(event){
            $('#changeAgentPass').modal('show');
            $('#changeAgentPass').find('input[name=id]').val($(this).data('id'));
            $('#changeAgentPass').find('input[name=route]').val($(this).data('uri'));
            event.preventDefault();
        });   

        $(document).on('click','.inline-readmore', function(event){ 
            if($(this).prev().is(":visible")){
                $(this).prev('.full-string-span').hide();
                $(this).html('<small>...more</small>');
            }else{
                $(this).prev('.full-string-span').show();
                $(this).html('<small> less</small>');
            }
            event.preventDefault();
        });

        $(document).on('click','.nav-tabs li.nav-item a.nav-link', function(event){
            blockId = $(this).attr('href');
            $('.tab-pane').removeClass('active');
            $(blockId).addClass('active');
        });   

        $(document).on('dblclick','*[data-khref]', function(event){
            window.location = $(this).data("khref");
        });      
    });

    function showAjaxLoader() {
        $('.ajaxLoader').show();
    }

    function hideAjaxLoader() {
        $('.ajaxLoader').hide();
    }
</script>


