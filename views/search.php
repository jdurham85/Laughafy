<?php
session_start();

class search
{
    private static function header()
    {
        require "inner_header.php";
        ?>
		<script src="js/search_inc.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
                search_exe();
            });
		</script>
		<?php
}

    public static function searchp()
    {
        self::header();
        $c = new config;
        ?>
		<table id="searchbox_header" cellpadding="5" cellspacing="5">
			<tr>
				<td style="text-align: center; width: 10%;">
					<img style="width: 60px; height: 60px; border-radius: 100%;" src="<?php echo profiled::MemberProfilePic($c->get_session_id()); ?>" />
				</td>
				<td>
					<input id="search_input_txt" name="search_input_txt" onkeyup="search();" type="text" placeholder="Search....." />
				</td>
			</tr>
			<tr style="display: none;">
				<td colspan="2">
					<!--div id="searchbox_advance_search_btn">Advance Search</div-->
					<table id="searchbox_advance_search_tb">
						<tr>
							<td width="20%">Gender</td>
							<td>
								<select id="advance_search_gender_lv">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
								</select>
							</td>
						</tr>
                        <tr>
                            <td>Select Country:
                                <select id="country" name="country"></select>
                            </td>
                        </tr>
                        <tr>
                            <td>Select State or Region:
                                <select id="region" name="region">

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Select City:
                                <select id="city" name="city">

                                </select>
                            </td>
                        </tr>
					</table>
				</td>
			</tr>
		</table>
		<div id="searchbox_body"></div>
		<?php
}

}
?>