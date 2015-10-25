<?php $this->load->view('message') ?>
<title><?= $title ?></title>
<div class="titling"><h1><?= $title ?></h1></div>
<div class="kegiatan">
    <script type="text/javascript">
        var data = '';
        $(function() {
            $('#mytab a:first').tab('show');
            //$('#tabs').tabs();
            my_ajax('<?= base_url() ?>masterdata/user_group','#tab1');
            $('#tabs-1').click(function(){
                if($('#tab1').html()=== ''){
                    my_ajax('<?= base_url('masterdata/user_group') ?>','#group');
                }
                
            });
            $('#tabs-2').click(function(){
                if($('#tab2').html()=== ''){
                    my_ajax('<?= base_url('masterdata/user_account') ?>','#user');
                }
            });
        });
    
        function my_ajax(url,element){
            $.ajax({
                url: url,
                dataType: '',
                success: function( response ) {
                    $(element).html(response);
                }
            });
        }
        
        function paging(page, tab, search) {
            var active = $('#tabs').tabs('option','active');
            paginate(page, tab, search, active);
            //load_data_barang(page, search);
        }
        
        function paginate(page, tab, search, active) {
            if (active === 0) {
                get_group_list(page, search);
            }
            if (active === 1) {
                get_user_list(page, search);
            }
        }
    </script>

<!--    <div id="tabs">
        <ul>
            <li><a class="group" href="#group">User Group</a></li>
            <li><a class="user" href="#user">User Account</a></li>
        </ul>

        <div id="group"></div>
        <div id="user"></div>
    </div>-->
    
    <ul id="mytab" class="nav nav-tabs">
        <li class="link_tab" id="tabs-1"><a href="#tab1" data-toggle="tab"> Level User</a></li>
        <li class="link_tab" id="tabs-2"><a href="#tab2" data-toggle="tab"> User Account</a></li>
    </ul>
    <br/>
    <div class="tab-content">
        <div class="tab-pane" id="tab1"></div>
        <div class="tab-pane" id="tab2"></div>
    </div>


</div>