	<!-- jQuery 2.0.2 -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo cfg('template', 'site_url'); ?>templates/admin/assets/js/AdminLTE/app.js" type="text/javascript"></script>
	
	<!-- Select2 -->
	<script src="<?php echo cfg('template', 'site_url');?>templates/admin/assets/plugins/select2/select2.js" type="text/javascript"></script>
	<script>

      var placeholder = "";

      $('.select2, .select2-multiple').select2({ placeholder: placeholder });

      $('button[data-select2-open]').click(function(){
        $('#' + $(this).data('select2-open')).select2('open');
      });

      
        var select2OpenEventName = "select2-open";

        $(':checkbox').on( "click", function() {
          $(this).parent().nextAll('select').select2("enable", this.checked );
        });
      

      $(".select2, .select2-multiple, .select2-allow-clear, .select2-remote").on( select2OpenEventName, function() {
        if ( $(this).parents('[class*="has-"]').length ) {
          var classNames = $(this).parents('[class*="has-"]')[0].className.split(/\s+/);
          for (var i=0; i<classNames.length; ++i) {
              if ( classNames[i].match("has-") ) {
                $('#select2-drop').addClass( classNames[i] );
              }
          }
        }

      });

    </script>