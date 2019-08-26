<?php
/**
 *
 * @package    WordPress
 * @subpackage themename
 */

//$lrsgen = new LRSGEN();

get_header();
the_post(); ?>

    <main>
        <?php //echo $lrsgen->getMainContent($post->ID); ?>
        <div class="table">
            <div class="tableCell fourth">
                <div class="panel">
                    <div class="panelTitle"><h3>Stats</h3></div>
                    <div class="panelContent hasTable">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Total Reservations</th>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <th>Reservations Value</th>
                                    <td>$2,736</td>
                                </tr>
                                <tr>
                                    <th>Average Reservation Value</th>
                                    <td>$152.99</td>
                                </tr>
                                <tr>
                                    <th>sdvd</th>
                                    <td>sfsdeee</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tableCell fourth">
                <div class="panel">
                    <div class="panelTitle"><h3>Pending Transactions</h3></div>
                    <div class="panelContent"></div>
                </div>
            </div>
            <div class="tableCell half last">
                <div class="panel">
                    <div class="panelTitle"><h3>Current Rates:</h3></div>
                    <div class="panelContent hasTable">
                        rates table
                    </div>
                </div>
            </div>
        </div>

        <div class="table">
            <div class="tableCell third">
                <div class="panel">
                    <div class="panelTitle"><h3>Popular Properties</h3></div>
                    <div class="panelContent hasTable">
                        data 
                    </div>
                </div>
            </div>
            <div class="tableCell third">
                <div class="panel">
                    <div class="panelTitle"><h3>Popular Properties</h3></div>
                    <div class="panelContent hasTable">
                        data 
                    </div>
                </div>
            </div>
            <div class="tableCell third">
                <div class="panel">
                    <div class="panelTitle"><h3>Popular Properties</h3></div>
                    <div class="panelContent hasTable">
                        data 
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
