                        {foreach $list as $tienda}
                                <tr colspan="2">
                                	<td style="border:1px solid #D6D4D4;">
                                		<table class="table">
                                			<tr>
                                				<td width="10">&nbsp;</td>
                                				<td>
                                					<font size="2" face="Open-sans, sans-serif" color="#555454">
                                						{$tienda['name']}
                                					</font>
                                				</td>
                                				<td width="10">&nbsp;</td>
                                			</tr>
                                		</table>
                                	</td>
                                	<td style="border:1px solid #D6D4D4;">
                                        <table class="table">
                                			<tr>
                                				<td width="10">&nbsp;</td>
                                				<td style="text-align:right">
                                					<font size="2" face="Open-sans, sans-serif" color="#555454">
                                						<strong>{$tienda['total']}</strong>
                                					</font>
                                            	</td>
                                				<td width="10">&nbsp;</td>
                                			</tr>
                                		</table>
                                	</td>
                                </tr>
                        {/foreach}