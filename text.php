<div class="sec2">
                                        <div class="left-side-form">
                                            
                                            <label>Phone:</label><br>
                                            <div class="form-left-to-w3l">
                                                <input type="text" name="phone" placeholder="" required="" value="<?php echo $db_phone; ?>">
                                                <div class="clear"></div>
                                            </div>
                                          <label>Address:</label><br>
                                            <div>
                                                <textarea type="text" name="address" placeholder="" required="" value=""><?php echo $db_address; ?></textarea>
                                            </div>
                                          

                                        </div>
                                        <div class="right-side-form">
                                            
                                             <label>Location:</label><br>
                                                <div class="form-left-to-w3l">
                                                    <input type="text" id="title" name="location" placeholder="" required="" value="<?php echo $db_location; ?>" readonly="">

                                                    <div class="clear"></div>
                                                </div>
                                            
                                            
                                            <label>Registration Date:</label><br>
                                            <div>
                                                <input type="text" name="date" placeholder="" required="" value="<?php echo $db_date; ?>">
                                            </div>
                                            <label></label><br><br>

                                        </div>
                                    </div>