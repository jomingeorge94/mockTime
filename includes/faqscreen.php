<section id="faq" class="faq-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Frequently Asked Questions</h1>
					<hr class="star-primary">
                    <ul id="basics" class="cd-faq-group">
                    	<?php 
                            $sub = get_faq();
                            //die(print_r($sub));
                            if ($sub!= null) {
                                foreach($sub as $s ) {
                                    ?>  
									<li>
										<a class="cd-faq-trigger" href="#0"><?php echo $s['faq_question'] ?></a>
										<div class="cd-faq-content">
											<p><?php echo $s['faq_answer'] ?></p>
											<p class="faq_date_updated">Last Updated: <?php echo date("D d F Y,  H:i:s", strtotime(safe_output($s['faq_date_updated']))) ?></p>
										</div> <!-- cd-faq-content -->
									</li>
									<?php 
								} 
                            } else {
                                    echo '<li><strong>Exams not available</strong></li>';
                                }
                        ?>

							
						</ul> <!-- cd-faq-group -->
						<a href="#0" class="cd-close-panel">Close</a>
                </div>
            </div>
        </div>
</section>