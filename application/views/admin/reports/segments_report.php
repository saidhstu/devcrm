<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        
                        This is segments reports test file...
                        
                            <?php foreach($segments as $s) { ?>
                            <ul>
                                <li> <?php echo($s['name']); ?></li>
                            </ul>
                            
                           <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

