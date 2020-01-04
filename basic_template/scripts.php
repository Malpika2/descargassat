  <!-- JS Global Compulsory -->
  <script src="<?php  echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>

  <script src="<?php  echo base_url();?>assets/vendor/popper.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/bootstrap/bootstrap.min.js"></script>

  <script src="<?php  echo base_url();?>assets/vendor/cookiejs/jquery.cookie.js"></script>


  <!-- jQuery UI Core -->

  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/widget.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/version.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/keycode.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/position.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/unique-id.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/safe-active-element.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/jquery-ui.js"></script>

  <!-- jQuery UI Helpers -->
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/widgets/menu.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/widgets/mouse.js"></script>

  <!-- jQuery UI Widgets -->
  <script src="<?php  echo base_url();?>assets/vendor/jquery-ui/ui/widgets/datepicker.js"></script>

  <!-- JS Plugins Init. -->
  <script src="<?php  echo base_url();?>assets/vendor/appear.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/flatpickr/dist/js/flatpickr.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/chartist-js/chartist.min.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/chartist-js-tooltip/chartist-plugin-tooltip.js"></script>
  <script src="<?php  echo base_url();?>assets/vendor/fancybox/jquery.fancybox.min.js"></script>

  <!-- JS Unify -->
  <script src="<?php  echo base_url();?>assets/js/hs.core.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.side-nav.js"></script>
  <script src="<?php  echo base_url();?>assets/js/helpers/hs.hamburgers.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.range-datepicker.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.datepicker.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.dropdown.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.scrollbar.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.area-chart.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.donut-chart.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.bar-chart.js"></script>
  <script src="<?php  echo base_url();?>assets/js/helpers/hs.focus-state.js"></script>
  <script src="<?php  echo base_url();?>assets/js/components/hs.popup.js"></script>

  <!-- JS Custom -->
  <!-- <script src="<?php  echo base_url();?>assets/js/custom.js"></script> -->
  <!-- JS Plugins Init. -->
  <script src="<?php echo base_url();?>/assets/vendor/chosen/chosen.jquery.js"></script>
  <!-- JS Unify -->
  <script src="<?php echo base_url();?>/assets/js/components/hs.select.js"></script>


  <script>
    $(document).on('ready', function () {
      // initialization of custom select
      $('.js-select').selectpicker();
  
      // initialization of hamburger
      $.HSCore.helpers.HSHamburgers.init('.hamburger');
  
      // initialization of charts
      $.HSCore.components.HSAreaChart.init('.js-area-chart');
      $.HSCore.components.HSDonutChart.init('.js-donut-chart');
      $.HSCore.components.HSBarChart.init('.js-bar-chart');
  
      // initialization of sidebar navigation component
      $.HSCore.components.HSSideNav.init('.js-side-nav', {
        afterOpen: function() {
          setTimeout(function() {
            $.HSCore.components.HSAreaChart.init('.js-area-chart');
            $.HSCore.components.HSDonutChart.init('.js-donut-chart');
            $.HSCore.components.HSBarChart.init('.js-bar-chart');
          }, 400);
        },
        afterClose: function() {
          setTimeout(function() {
            $.HSCore.components.HSAreaChart.init('.js-area-chart');
            $.HSCore.components.HSDonutChart.init('.js-donut-chart');
            $.HSCore.components.HSBarChart.init('.js-bar-chart');
          }, 400);
        }
      });
  
      // initialization of range datepicker
      $.HSCore.components.HSRangeDatepicker.init('#rangeDatepicker, #rangeDatepicker2, #rangeDatepicker3');
  
      // initialization of datepicker
      $.HSCore.components.HSDatepicker.init('#datepicker', {
        dayNamesMin: [
          'SU',
          'MO',
          'TU',
          'WE',
          'TH',
          'FR',
          'SA'
        ]
      });
  
      // initialization of HSDropdown component
      $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
  
      // initialization of custom scrollbar
      $.HSCore.components.HSScrollBar.init($('.js-custom-scroll'));
  
      // initialization of popups
      $.HSCore.components.HSPopup.init('.js-fancybox', {
        btnTpl: {
          smallBtn: '<button data-fancybox-close class="btn g-pos-abs g-top-25 g-right-30 g-line-height-1 g-bg-transparent g-font-size-16 g-color-gray-light-v3 g-brd-none p-0" title=""><i class="hs-admin-close"></i></button>'
        }
      });
    });

  </script>
  <!-- JS Plugins Init. -->
<script >
  $(document).ready(function () {
    // initialization of custom select
    $.HSCore.components.HSSelect.init('.js-custom-select');

    // initialization of forms
    $.HSCore.components.HSDatepicker.init('#datepickerInline');
  }); 
</script>
<script type="text/javascript">
   $(document).ready(function() {
    $( "#cliente" ).autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: "<?php echo base_url('digital/Backend/get_autocomplete/?');?>",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.Nombre+' '+obj.ApellidoP;
               }); 
               response(resp);
            }
        });
    },
    minLength: 1
 });
});
</script>
