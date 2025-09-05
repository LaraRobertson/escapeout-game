<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


// Generates a unique id for aria-controls.
$unique_id = wp_unique_id( 'p-' );

// Function to iteratively search for a
// given key=>value


$clue_icon = array(
    array(
        'id'    => 'diary',
        'label' => __( 'Diary' ),
        'icon'  => '<svg height="40" width="40" viewBox="230 230 750 750"
                        xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <rect width="1200" height="1200" fill="transparent"/>
                            <path
                                d="m864.8 252.38h-469.66c-37.785 0-68.457 26.688-68.457 59.395v539.04c0 0.91406 0.23437 1.7422 0.29687 2.6562-0.23437 1.9766-0.29687 4.0156-0.29687 6.0508 0 33.562 27.277 60.84 60.84 60.84h123.48v13.816c0 5.0781 2.7148 9.5938 7.0273 11.867 4.8984 2.4805 10.746 1.3594 14.438-2.8047l25.477-28.426 26.895 28.871c2.4219 2.5664 5.5781 3.9258 8.8555 3.9258 1.8906 0 3.7773-0.44141 5.5195-1.3594 4.2227-2.1836 6.8789-6.7305 6.8789-11.777l-0.03125-14.051h258.74c4.6953 0 8.4727-3.7773 8.4727-8.4727v-27.129c0-4.6953-3.7773-8.4727-8.4727-8.4727h-18.656v-33.477h18.656c4.6953 0 8.4727-3.7773 8.4727-8.4727v-573.55c0.089844-4.6953-3.7773-8.4727-8.4727-8.4727zm-8.4414 546.3h-417.92v-529.29h417.92zm-512.71-486.91c0-23.438 23.113-42.391 51.453-42.391h26.301v529.39h-33.918c-17.238 0-32.797 7.2617-43.895 18.805v-505.8zm167.32 564.51h-123.48c-9.0625 0-16.77-7.7031-16.77-16.77 0-9.0625 7.7031-16.77 16.77-16.77h123.48zm78.141 47.172-19.719-21.168c-3.1016-3.3359-7.1719-5.1367-11.484-5.1367h-0.14844c-4.3672 0.089844-8.5312 1.9766-11.57 5.3711l-18.215 20.34v-80.059h61.137zm267.24-20.043h-250.24v-10.215h250.27l0.03125 10.215zm-27.16-27.129h-223.09v-33.477h223.17v33.477zm27.16-50.48h-468.87c-18.598 0-33.711 15.113-33.711 33.711 0 18.598 15.113 33.711 33.711 33.711h123.48v10.215l-123.48-0.03125c-24.176 0-43.895-19.66-43.895-43.895 0-24.176 19.66-43.895 43.895-43.895h468.84zm-369.03-100.34c17.152 0 31.055 13.992 31.055 31.055 0 4.6953 3.7773 8.4727 8.4727 8.4727h240.91c4.6953 0 8.4727-3.7773 8.4727-8.4727 0-17.152 13.992-31.055 31.055-31.055 4.6953 0 8.4727-3.7773 8.4727-8.4727v-365.84c0-4.6953-3.7773-8.4727-8.4727-8.4727-17.152 0-31.055-13.992-31.055-31.055 0-4.6953-3.7773-8.4727-8.4727-8.4727h-240.86c-4.6953 0-8.4727 3.7773-8.4727 8.4727 0 17.152-13.992 31.055-31.055 31.055-4.6953 0-8.4727 3.7773-8.4727 8.4727v365.84c-0.058594 4.6055 3.7188 8.4727 8.4141 8.4727zm8.5312-366.61c19.719-3.543 35.305-19.129 38.848-38.848h225.5c3.543 19.719 19.129 35.305 38.848 38.848v350.34c-19.719 3.543-35.305 19.129-38.848 38.848h-225.57c-3.543-19.719-19.129-35.305-38.848-38.848v-350.34zm52.754 161.8h197.55c4.6953 0 8.4727-3.7773 8.4727-8.4727v-94.465c0-4.6953-3.7773-8.4727-8.4727-8.4727l-197.55 0.03125c-4.6953 0-8.4727 3.7773-8.4727 8.4727v94.375c0 4.7539 3.7773 8.5312 8.4727 8.5312zm8.4727-94.465h180.55v77.461h-180.55zm4.6055 188.78c0-4.6953 3.7773-8.4727 8.4727-8.4727h85.168c4.6953 0 8.4727 3.7773 8.4727 8.4727 0 4.6953-3.7773 8.4727-8.4727 8.4727h-85.109c-4.6641 0-8.5312-3.7773-8.5312-8.4727zm132.19 8.4727c-4.6953 0-8.4727-3.7773-8.4727-8.4727 0-4.6953 3.7773-8.4727 8.4727-8.4727h28.637c4.6953 0 8.4727 3.7773 8.4727 8.4727 0 4.6953-3.7773 8.4727-8.4727 8.4727zm-72.414 34.895c0 4.6953-3.7773 8.4727-8.4727 8.4727h-42.773c-4.6953 0-8.4727-3.7773-8.4727-8.4727 0-4.6953 3.7773-8.4727 8.4727-8.4727h42.773c4.6055 0.03125 8.4727 3.8086 8.4727 8.4727zm109.49 0c0 4.6953-3.7773 8.4727-8.4727 8.4727h-71.023c-4.6953 0-8.4727-3.7773-8.4727-8.4727 0-4.6953 3.7773-8.4727 8.4727-8.4727h71.023c4.6953 0.03125 8.4727 3.8086 8.4727 8.4727z"/>
                        </g>
                    </svg> ',
    ),
    array(
        'id'    => 'tornPaper',
        'label' => __( 'A Torn Piece of Paper' ),
        'icon'  => '<svg width="40" height="40" viewBox="15 15 512 512" xmlns="http://www.w3.org/2000/svg">
                     <path d="m85.332 437.33c0 2.3086 0.75 4.5547 2.1328 6.4023l40 53.332c2.0156 2.6875 5.1797 4.2656 8.5352 4.2656s6.5195-1.5781 8.5352-4.2656l31.465-41.973 31.465 41.973c2.0977 2.5547 5.2305 4.0352 8.5352 4.0352s6.4375-1.4805 8.5352-4.0352l31.465-41.973 31.465 41.973c2.0977 2.5547 5.2305 4.0352 8.5352 4.0352s6.4375-1.4805 8.5352-4.0352l31.465-41.973 31.465 41.973c2.0156 2.6875 5.1797 4.2656 8.5352 4.2656s6.5195-1.5781 8.5352-4.2656l40-53.332c1.3828-1.8477 2.1328-4.0938 2.1328-6.4023v-320c0.082031-0.65234 0.082031-1.3164 0-1.9727-0.18359-0.90625-0.48828-1.7891-0.90625-2.6133l-0.53516-0.74609c-0.46094-0.82422-1.0352-1.5781-1.707-2.2383l-96-96c-0.64844-0.65234-1.3828-1.207-2.1875-1.6562l-0.58594-0.32031c-0.82812-0.5-1.7266-0.875-2.668-1.1172-0.6875-0.09375-1.3867-0.09375-2.0781 0h-202.67c-8.4844 0-16.625 3.3711-22.625 9.3711-6.0039 6-9.375 14.141-9.375 22.629zm304.91-330.66h-52.801 0.003906c-1.7969 0-3.5195-0.71484-4.7891-1.9844-1.2734-1.2695-1.9844-2.9922-1.9844-4.7891v-52.801zm-283.57-64c0-5.8906 4.7734-10.668 10.664-10.668h192v67.895c0 7.4531 2.9609 14.602 8.2344 19.875 5.2695 5.2695 12.418 8.2305 19.875 8.2305h67.891v305.76l-29.332 39.148-31.52-41.977c-2.0039-2.6719-5.1406-4.25-8.4805-4.2656-3.3555 0-6.5195 1.5781-8.5352 4.2656l-31.465 41.973-31.465-41.973c-2.0977-2.5547-5.2305-4.0352-8.5352-4.0352s-6.4375 1.4805-8.5352 4.0352l-31.465 41.973-31.465-41.973c-2.0156-2.6875-5.1797-4.2656-8.5352-4.2656s-6.5195 1.5781-8.5352 4.2656l-31.465 41.973-29.332-39.145z"/>
                     <path d="m138.67 106.67h122.66c5.8906 0 10.668-4.7773 10.668-10.668s-4.7773-10.668-10.668-10.668h-122.66c-5.8906 0-10.668 4.7773-10.668 10.668s4.7773 10.668 10.668 10.668z"/>
                     <path d="m138.67 186.67h229.33c5.8906 0 10.668-4.7773 10.668-10.668s-4.7773-10.668-10.668-10.668h-229.33c-5.8906 0-10.668 4.7773-10.668 10.668s4.7773 10.668 10.668 10.668z"/>
                     <path d="m138.67 246.67h229.33c5.8906 0 10.668-4.7773 10.668-10.668s-4.7773-10.668-10.668-10.668h-229.33c-5.8906 0-10.668 4.7773-10.668 10.668s4.7773 10.668 10.668 10.668z"/>
                     <path d="m138.67 306.67h229.33c5.8906 0 10.668-4.7773 10.668-10.668s-4.7773-10.668-10.668-10.668h-229.33c-5.8906 0-10.668 4.7773-10.668 10.668s4.7773 10.668 10.668 10.668z"/>
                     <path d="m368 366.67c5.8906 0 10.668-4.7773 10.668-10.668s-4.7773-10.668-10.668-10.668h-229.33c-5.8906 0-10.668 4.7773-10.668 10.668s4.7773 10.668 10.668 10.668z"/>
                    </svg>',
    ),
);
$nonce = wp_create_nonce( 'wp_rest' );
// Adds the global state.

$playZones = array();
$puzzleArray = array();
/*$quesArray = array();
$clueTextArray = array();
$hintTextArray = array();*/
$clueArray = array();
$hintArray = array();
// need to concatenate puzzle arrays from all zones...
$paIndex = 0;
$caIndex = 0;
$haIndex = 0;
for ($i = 0; $i < count($attributes['playZones']); $i++) {
    if ($attributes['playZones'][$i]["disabled"] === "No") {
        $playZones[$i]['index'] = $i;
        $playZones[$i]['id'] = $attributes['playZones'][$i]["id"];
	    $playZones[$i]['zoneID'] = $attributes['playZones'][$i]["id"];
        $playZones[$i]['name'] = $attributes['playZones'][$i]["name"];
        $playZones[$i]['description'] = $attributes['playZones'][$i]["description"];
        $playZones[$i]['order'] = $attributes['playZones'][$i]["order"];
	    $playZones[$i]['lat'] = $attributes['playZones'][$i]["lat"];
	    $playZones[$i]['long'] = $attributes['playZones'][$i]["long"];
        $playZones[$i]['imageID'] = $attributes['playZones'][$i]["imageID"];
        if ($attributes['playZones'][$i]["imageID"] != '') {
            $playZones[$i]['zoneHasImage'] = true;
        } else {
            $playZones[$i]['zoneHasImage'] = false;
        }
        if (!empty($attributes['playZones'][$i]['puzzleArray'])) {
            for ($j = 0; $j < count($attributes['playZones'][$i]['puzzleArray']); $j++) {
                // index would be 1,2,3 (zone 2, pa1) - so length would be 3
                // don't need disabled ones
                if ($attributes['playZones'][$i]['puzzleArray'][$j]["disabled"] === "No") {
                    $puzzleArray[$paIndex]["puzzleID"] = 'input' . $paIndex;
	                $puzzleArray[$paIndex]["puzzleIndex"] = $paIndex;
                    /**
                    *   need to build a separate question and answer object (associative array in php)?
                    *   so that people can't see questions and answers in context before playing.  How about:
                    *   question is not in context and answers are encrypted?
                    */
	                //$quesArray[$paIndex]['input' . $paIndex] = "test";
                    $puzzleArray[$paIndex]["zoneID"] = $attributes['playZones'][$i]["id"];
                    $puzzleArray[$paIndex]['name'] = $attributes['playZones'][$i]['puzzleArray'][$j]["name"];
                    $puzzleArray[$paIndex]['clue'] = $attributes['playZones'][$i]['puzzleArray'][$j]["clue"];
                    //$puzzleArray[$paIndex]['question'] = $attributes['playZones'][$i]['puzzleArray'][$j]["question"];
                    $puzzleArray[$paIndex]['sols'] = $attributes['playZones'][$i]['puzzleArray'][$j]["sols"];
                    $puzzleArray[$paIndex]['order'] = $attributes['playZones'][$i]['puzzleArray'][$j]["order"];
                    $puzzleArray[$paIndex]['iconPath'] = $attributes['playZones'][$i]['puzzleArray'][$j]["iconPath"];
                    $puzzleArray[$paIndex]['modalOpen'] = false;
                    $puzzleArray[$paIndex]['guess'] = "";
                    $puzzleArray[$paIndex]['solved'] = false;
                    $paIndex++;
                }
            }
        }
        if (!empty($attributes['playZones'][$i]['clueArray'])) {
            for ($j = 0; $j < count($attributes['playZones'][$i]['clueArray']); $j++) {
                // index would be 1,2,3 (zone 2, pa1) - so length would be 3
                if ($attributes['playZones'][$i]['clueArray'][$j]["disabled"] === "No") {
                    $clueArray[$caIndex]["clueID"] = 'clue' . $caIndex;
	                $clueArray[$caIndex]["clueIndex"] = $caIndex;
                    $clueArray[$caIndex]["zoneID"] = $attributes['playZones'][$i]["id"];
                    $clueArray[$caIndex]['name'] = $attributes['playZones'][$i]['clueArray'][$j]["name"];
	                /**
	                 *   need to build a separate clueText array?
	                 *   so that people can't see clues in context before playing.  How about:
	                 *   clue text in context?
	                 */
	                //$clueTextArray[$caIndex]['clue' . $caIndex] = "text";
                    //$clueArray[$caIndex]['text'] = $attributes['playZones'][$i]['clueArray'][$j]["text"];
                    $clueArray[$caIndex]['iconPath'] = $attributes['playZones'][$i]['clueArray'][$j]["iconPath"];
                    $clueArray[$caIndex]['imageID'] = $attributes['playZones'][$i]['clueArray'][$j]["imageID"];
                    if ($attributes['playZones'][$i]['clueArray'][$j]["imageID"] != '') {
                        $clueArray[$caIndex]['clueHasImage'] = true;
                    } else {
                        $clueArray[$caIndex]['clueHasImage'] = false;
                    }
                    $clueArray[$caIndex]['order'] = $attributes['playZones'][$i]['clueArray'][$j]["order"];
                    $clueArray[$caIndex]['clueDisplayOn'] = false;
                    $caIndex++;
                }
            }
        }
        if (!empty($attributes['playZones'][$i]['hintArray'])) {
            for ($j = 0; $j < count($attributes['playZones'][$i]['hintArray']); $j++) {
                // index would be 1,2,3 (zone 2, pa1) - so length would be 3
                if ($attributes['playZones'][$i]['hintArray'][$j]["disabled"] === "No") {
                $hintArray[$haIndex]["hintID"] = 'hint' . $haIndex;
                $hintArray[$haIndex]["hintIndex"] = $haIndex;
                $hintArray[$haIndex]["zoneID"] = $attributes['playZones'][$i]["id"];
                $hintArray[$haIndex]['name'] = $attributes['playZones'][$i]['hintArray'][$j]["name"];
                /**
                 *   need to build a separate clueText array?
                 *   so that people can't see clues in context before playing.  How about:
                 *   clue text in context?
                 */
                //$hintTextArray[$haIndex]['hint' . $haIndex] = $attributes['playZones'][$i]['hintArray'][$j]["text"];
                //$hintArray[$haIndex]['text'] = $attributes['playZones'][$i]['hintArray'][$j]["text"];
                $hintArray[$haIndex]['order'] = $attributes['playZones'][$i]['hintArray'][$j]["order"];
                $hintArray[$haIndex]['hintDisplayOn'] = false;
                $hintArray[$haIndex]['hintUsed'] = false;
                $haIndex++;
                }
            }
        }
    }
}
$siteUrl = get_site_url();
wp_interactivity_state(
    'escapeout-game',
    array(
        'isDark'    => false,
        'darkText'  => esc_html__( 'Switch to Light', 'escapeout-game' ),
        'lightText' => esc_html__( 'Switch to Dark', 'escapeout-game' ),
        'themeText'	=> esc_html__( 'Switch to Dark', 'escapeout-game' ),
        'userID' => get_current_user_id(),
        'user' => get_current_user(),
        'zoneID' => '',
        'zoneDescription' => $playZones[0]['description'],
        'zoneName' => $playZones[0]['name'],
        'puzzleModalVisible' => false,
        'alertVisible' => false,
        'alertText' => '',
        'clueText' => '',
        'clueDisplayOn' => "",
        'gdo' => "",
        'clueTextArray' => [],
        'hintText' => '',
        'hintDisplayOn' => "",
        'hintTextArray' => [],
        'puzzleQuestion' => '',
        'puzzleName' => '',
        'puzzleOpen' => '',
        'puzzleQuestionArray' => [],
        'quitVisible' => false,
        'alertDisplayOn'=> '',
        'helpVisible' => true,
        'zoneHelpVisible'=> true,
        'puzzleHelpVisible'=> true,
        'clueHelpVisible'=> true,
        'hintHelpVisible'=> true,
        'teamHelpVisible'=> false,
        'waiverHelpVisible'=> false,
        'modalPublicMapOpen'=> false,
        'modalPrivateMapOpen'=> false,
        'modalPublicImageOpen'=> false,
        'modalStatsOpen'=> false,
        'modalLeaderBoardOpen'=> false,
        'modalCommentsOpen'=> false,
        'modalGameMapOpen'=> false,
        'hintUsedArray' => [],
        'solvedArray' => [],
        'showWaiver' => false,
        'showTeam' => false,
        'showLocationWarning' => false,
        'errorMessage' => '',
        'gameScoreID' => '',
        'timeStart' => '',
        'formattedDate' => '',
        'gameScore' => '',
        'showGameScore' => false,
        'rating' => '',
        'anotherGame' => '',
        'alertStartVisible' => false,
        'siteURL' => $siteUrl,
        'nonce' => $nonce
    )
);
print_r($attributes);
//https://stackoverflow.com/questions/2699086/sort-a-2d-array-by-a-column-value
usort($playZones, fn($a, $b) => $a['order'] <=> $b['order']);
usort($puzzleArray, fn($a, $b) => $a['order'] <=> $b['order']);
usort($clueArray, fn($a, $b) => $a['order'] <=> $b['order']);
$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
$user_email = $current_user->user_email;
$user_displayName = $current_user->display_name;
if ($attributes['userMustBeLoggedIn'] === "yes") {
    /** @var TYPE_NAME $userMustBeLoggedIn */
    $userMustBeLoggedIn = true;
} else {
    $userMustBeLoggedIn = false;
}
if ($user_displayName != "") {
    $displayName = $user_displayName;
} else {
    $displayName = $user_email;
}

$designer_email = get_the_author_meta('user_email', get_the_author_meta( 'ID' ));
$designer_name = get_the_author_meta('display_name', get_the_author_meta( 'ID' ));
$gamePost_id = get_the_ID();
$upload_dir   = wp_upload_dir();
$key_1_value = get_post_meta( get_the_ID(), '_wporg_meta_key', true );

if ($user_email) {
    $userIsLoggedIn = true;
} else {
	$userIsLoggedIn = false;
    $displayName = "Not Logged In";
}
$assetDir = "/wp-content/plugins/escapeout-game/assets/";
$firstZoneID = $playZones[0]['id'];
$gameID = $attributes['gameID'];
global $wpdb;
$table_name = $wpdb->prefix . 'game_score';
$resultLeaderBoard = $wpdb->get_results ( "SELECT * FROM `$table_name` WHERE `firstTime` = 'yes'  AND `gameID` = '$gameID' AND `completed` = 'yes' ORDER BY `totalTime` LIMIT 20" );
$resultStats = $wpdb->get_results ( "SELECT * FROM `$table_name` WHERE `userEmail` = '$user_email' AND `gameID` = '$gameID' ORDER BY `timeStart`" );
$resultComments = $wpdb->get_results ( "SELECT * FROM `$table_name` WHERE `gameID` = '$gameID' AND `gameCommentPublicApproved` = 'yes' ORDER BY `timeStart`" );
//print_r($resultComments);
$firstTime="yes";
if (count($resultStats) > 0) {
    $firstTime='no';
}
global $post;
$post_slug = $post->post_name;
$frontendContext = array('testKey' => $key_1_value, 'firstTime' => $firstTime, 'gameSlug' => $post_slug, 'userIsLoggedIn' => $userIsLoggedIn , 'userMustBeLoggedIn' => $userMustBeLoggedIn, 'map1' => $attributes['map1'], 'map2' => $attributes['map2'], 'teamName' => $displayName, "waiverSigned" => $attributes["waiverSigned"], 'gameStart' => false, 'gameID' => $attributes['gameID'], 'gameName' => $attributes['gameName'], 'mission' => $attributes['mission'],'userEmail' => $user_email, 'designerEmail' => $designer_email, 'designerName' => $designer_name, 'userID' => $current_user_id, 'postID' => $gamePost_id, 'shift' => $attributes['shift'], 'showClueArray' => [], 'firstZoneID' => $firstZoneID, 'hintArray' => $hintArray, 'clueArray' => $clueArray, 'puzzleArray' => $puzzleArray, 'playZones' => $playZones, 'solved' => false, 'showCongrats' => false, 'showSorry' => false);
$gameContext = array( 'shift' => $attributes['shift'], 'showClueArray' => [], 'firstZoneID' => $firstZoneID, 'hintArray' => $hintArray, 'clueArray' => $clueArray, 'puzzleArray' => $puzzleArray, 'playZones' => $playZones, 'solved' => false, 'showCongrats' => false, 'showSorry' => false);
//print_r($post_slug);
?>
<div
    class="game-block-frontend"
    style="background-color:<?php echo $attributes['bgColor']?>;color: <?php echo $attributes['textColor']; color:?>"
    data-wp-class--changezindex="context.gameStart"
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="escapeout-game"
	<?php echo wp_interactivity_data_wp_context( $frontendContext); ?>
	data-wp-watch="callbacks.checkGameStart"
	data-wp-class--dark-theme="state.isDark"
>
	<div class="game-start-bar"
		id="<?php echo esc_attr( $unique_id ); ?>"
		data-wp-bind--hidden="context.gameStart"
	>
        <?php if ($key_1_value === "eo-test-game") {?>
            <div style="text-align:center;background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>">TESTING</div>
        <?php } ?>

        <?php /* user is logged in */ ?>
             <div data-wp-bind--hidden="!context.userIsLoggedIn">
            Welcome  <strong><?php echo $displayName; ?></strong>
            <?php if ($firstTime==="no") {
                echo "<br /><span class='small italics'>(you have played this game before)</span>";
            } ?>
            </div>
        <?php /* user is NOT logged in and game requires Login */ ?>
        <div data-wp-bind--hidden="!context.userMustBeLoggedIn">
            <div style="padding:5px" data-wp-bind--hidden="context.userIsLoggedIn">
                This game requires you to <a href="<?php echo $siteUrl . "/find-a-game" ?>"
                                             style="padding: 0 5px 5px 5px; background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>">log in</a> to play.
            </div>
            <div data-wp-bind--hidden="!context.userIsLoggedIn">
            </div>
        </div>
        <div data-wp-bind--hidden="context.userMustBeLoggedIn">
            <div class="game-text">You <strong>do not have to be logged in</strong> to play this game. There will be no record of your score
                after completion.
            </div>
        </div>

        <button class="button"
                data-wp-bind--hidden="!callbacks.userLoggedInAndMustBeLoggedIn"
                data-wp-on-async--click="actions.toggleStats"
                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
        >
			<?php esc_html_e( 'My Stats (this Game)', 'escapeout-game' ); ?>
        </button>
        <button class="button"
                data-wp-bind--hidden="!context.userMustBeLoggedIn"
                data-wp-on-async--click="actions.toggleLeaderBoard"
                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
        >
			<?php esc_html_e( 'Leaderboard', 'escapeout-game' ); ?>
        </button>
        <button class="button"
                data-wp-bind--hidden="!context.userMustBeLoggedIn"
                data-wp-on-async--click="actions.toggleComments"
                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
        >
            <?php esc_html_e( 'Comments/Ratings', 'escapeout-game' ); ?>
        </button>
        <hr/>
        <button id="showLevel" class="show-inline">what are levels?</button>
        <div id="hideLevelContainer" class="hide">
            Each game has a skill level:
            <ul>
                <li>Level 0 – very easy, play to learn how game works</li>
                <li>Level 1 – similar to a scavenger hunt with a little deduction</li>
                <li>Level 2 – some scavenger hunt style puzzles and more deduction</li>
                <li>Level 3 – more complicated puzzles with most requiring deduction</li>
            </ul>
            <button id="hideLevel" class="">hide level info</button>
        </div>
        <hr/>
        <div style="text-align:center; font-weight:bold; font-size: 1.2em;">Mission: <?php echo $attributes['mission'] ?></div>

        <div class="details">
            <ul>
                <li><div><strong>Designer Description:</strong></div>
                    <?php echo $content; ?>
                </li>
                <li>

                    <div><strong>Zones:</strong></div>
                    <?php echo $attributes['publicMapText'] ?>
                    <div style="text-align:center">
                    <div class="italics"><strong>It is best to be at Zone 1 Center before starting game.</strong></div>
                    <button class="button"
                            data-wp-bind--hidden="callbacks.checkPublicMap"
                            data-wp-on-async--click="actions.togglePublicMap"
                            aria-controls="<?php echo esc_attr( $unique_id );?>"
                            style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                    >
                        <?php esc_html_e( 'Zone Map', 'escapeout-game' ); ?>
                    </button>
                    <button class="button"
                            data-wp-on-async--click="actions.togglePublicImage"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                            style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                    >
		                <?php esc_html_e( 'Zone 1 Center Image', 'escapeout-game' ); ?>
                    </button>
                    </div>
                </li>
            </ul>
        </div>
        <hr/>
        <div class="help-container-start" data-wp-bind--hidden="!state.waiverHelpVisible">
            <div class='help-inner' style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>">
                <div>Signing the waiver helps the player understand that they should not harm their surroundings.</div>

                <button class="button"
                        data-wp-on--click="actions.toggleWaiverHelp"
                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                >
                    <?php esc_html_e( 'Close', 'escapeout-game' ); ?>
                </button>
            </div>
        </div>
        <div data-wp-bind--hidden="context.userMustBeLoggedIn">

            <div class="game-text" style="text-align:center">Before Starting the Game you must Sign the Waiver
                <img data-wp-on--click="actions.toggleWaiverHelp" class="question" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones"/>
            </div>
            <ul>
                <li>
                    <div>Waiver:
                        <span class="red-alert" data-wp-bind--hidden="context.waiverSigned">waiver needs to be signed</span>
                        <span class="red-alert" data-wp-bind--hidden="!context.waiverSigned">waiver is signed</span></div>
                    <button class="button"
                            data-wp-bind--hidden="state.showWaiver"
                            data-wp-on-async--click="actions.showWaiverToggle"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                            style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                    >
                        <?php esc_html_e( 'Show Waiver', 'escapeout-game' ); ?>
                    </button>

                    <div class="waiver-container" data-wp-bind--hidden="!state.showWaiver">
                        <div class="waiver-top"><?php echo $attributes["waiverTop"] ?></div>
                        <div class="waiver-body"><?php echo $attributes["waiverBody"] ?></div>
                        <button class="button"
                                data-wp-bind--hidden="context.waiverSigned"
                                data-wp-on-async--click="actions.signWaiver"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        >
                            <?php esc_html_e( 'Sign Waiver', 'escapeout-game' ); ?>
                        </button>
                        <button class="button"
                                data-wp-on-async--click="actions.showWaiverToggle"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        >
                            <?php esc_html_e( 'Close Waiver', 'escapeout-game' ); ?>
                        </button>
                        <button class="button"
                                data-wp-bind--hidden="state.showWaiver"
                                data-wp-on-async--click="actions.signWaiver"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                        >
                            <?php esc_html_e( 'Sign Waiver', 'escapeout-game' ); ?>
                        </button>
                    </div>
                </li>

            </ul>
            <hr/>
            <div class="red-alert" data-wp-text="state.errorMessage"></div>

            <div style="text-align:center;">
                <button class="button"
                        data-wp-bind--aria-expanded="context.isOpen"
                        data-wp-bind--hidden="state.showLocationWarning"
                        data-wp-on-async--click="actions.gameStart"
                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                >
                    <?php esc_html_e( 'Start Game', 'escapeout-game' ); ?>
                </button>
            </div>


            <div>
                <div class="modalContainerMap" data-wp-class--showmodal="state.showLocationWarning">
                    <div class="modal from-right">
                        <header class="modal_header">
                            <div><strong><?php echo $attributes['gameName']?></strong></div>
                        </header>
                    <div style="text-align:center;">
                        <div style="text-align:center; font-weight:bold;font-size: 1.4em; margin-top:20px; line-height: 1.5em;"><?php echo $attributes['gameIntro'] ?></div>
                        <div style="text-align:center; font-weight:bold; font-size: 1.2em; margin-top:20px; line-height: 1.3em;">Mission: <?php echo $attributes['mission'] ?></div>

                        <div class="red-alert" style="text-align:center; margin-top:10px;"><strong>Are you ready?</strong></div>
                        <div class="red-alert" style="text-align:center; margin:10px 0;"><strong>Are you near the Center of Zone 1?</strong></div>
                        <div style="text-align: center"><?php echo wp_get_attachment_image( $attributes['playZones'][0]["imageID"], "thumbnail", "", array( "class" => "img-responsive" ) );  ?></div>

                        <button class="button"
                                data-wp-bind--aria-expanded="context.isOpen"
                                data-wp-on-async--click="actions.gameStart"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                        >
                            <?php esc_html_e( 'Start Game - Time Starts', 'escapeout-game' ); ?>
                        </button>
                        <button class="button"
                                data-wp-bind--aria-expanded="context.isOpen"
                                data-wp-on-async--click="actions.hideLocationWarning"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                        >
                            <?php esc_html_e( 'No, Start Game Later', 'escapeout-game' ); ?>
                        </button>
                    </div>


                    </div>
                </div>
            </div>



            <div class="alert-container2" data-wp-bind--hidden="!state.alertStartVisible">
                <div class='alert-inner'>You are currently playing another game:<br/>
                    <div class="italics" data-wp-text="state.anotherGame"></div>
                    You can only play one game at a time, do you want to play that game?<br />
                    <button class="button"
                            data-wp-on--click="actions.quitAlertStartClose"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                    >
                        <?php esc_html_e( 'Play Other Game', 'escapeout-game' ); ?>
                    </button>

                    <br />Or would you like to play this game?<br />
                    <button class="button"
                            data-wp-on--click="actions.quit"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                    >
                        <?php esc_html_e( 'Play this Game', 'escapeout-game' ); ?>
                    </button>
                </div>
            </div>

        </div>
        <!-- end user does NOT have to be logged in -->

        <div data-wp-bind--hidden="!context.userMustBeLoggedIn">
            <div data-wp-bind--hidden="context.userIsLoggedIn"  style="text-align:center; font-weight:bold; font-size: 1.2em;">Mission: <span class="mission" data-wp-text="context.mission"></span></div>
            <div data-wp-bind--hidden="context.userIsLoggedIn" class="game-text center">
                To Play this game the user needs to create an account and log in.</div>
            <div data-wp-bind--hidden="!context.userIsLoggedIn">
                <div class="game-text">Before Starting the Game you must Sign the Waiver
                    <img data-wp-on--click="actions.toggleWaiverHelp" class="question" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />
                </div>
                <ul>
                    <li>
                        <div>Waiver:
                            <span class="red-alert" data-wp-bind--hidden="context.waiverSigned">waiver needs to be signed</span>
                            <span class="red-alert" data-wp-bind--hidden="!context.waiverSigned">waiver is signed</span></div>
                        <button class="button"
                                data-wp-bind--hidden="state.showWaiver"
                                data-wp-on-async--click="actions.showWaiverToggle"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                        >
                            <?php esc_html_e( 'Show Waiver', 'escapeout-game' ); ?>
                        </button>

                        <div class="waiver-container" data-wp-bind--hidden="!state.showWaiver"
                             style="color:<?php echo $attributes['textColor'];?>; background-color:<?php echo $attributes['bgColor']?>">
                            <div class="waiver-top"><?php echo $attributes["waiverTop"] ?></div>
                            <div class="waiver-body"><?php echo $attributes["waiverBody"] ?></div>
                            <button class="button"
                                    data-wp-bind--hidden="context.waiverSigned"
                                    data-wp-on-async--click="actions.signWaiver"
                                    aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                            >
                                <?php esc_html_e( 'Sign Waiver', 'escapeout-game' ); ?>
                            </button>
                            <button class="button"
                                    data-wp-on-async--click="actions.showWaiverToggle"
                                    aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                            >
                                <?php esc_html_e( 'Close Waiver', 'escapeout-game' ); ?>
                            </button>
                        </div>
                    </li>
                    <li>
                        <div class="help-container-start" data-wp-bind--hidden="!state.teamHelpVisible">
                            <div class='help-inner' style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>">
                                <div>
                                    Using a different display name could indicate you would like to play as a team or do not want to
                                    use your display name for comments or ratings or scores. To play as a team you can talk to each
                                    other, pass the phone around, etc. The only score that will
                                        count for the leaderboard will be the first time a logged in player plays and completes the game.
                                </div>

                                <button class="button"
                                        data-wp-on--click="actions.toggleTeamHelp"
                                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                >
                                    <?php esc_html_e( 'Close', 'escapeout-game' ); ?>
                                </button>

                            </div>
                        </div>
                        <div>Do you want to use a display name other than your user name?
                            <img data-wp-on--click="actions.toggleTeamHelp" class="question" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />
                        </div>
                        <button class="button"
                                data-wp-bind--hidden="state.showTeam"
                                data-wp-on-async--click="actions.showTeamToggle"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                        >
                            <?php esc_html_e( 'set Team Name', 'escapeout-game' ); ?>
                        </button>
                        <div class="team-container" data-wp-bind--hidden="!state.showTeam">

                            <div>Pick Team Name (defaults to display name)</div>
                            <input
                                    id="team-name2"
                                    aria-invalid="false"
                                    type="text"
                                    value="<?php echo $frontendContext['teamName'] ?>"
                            />
                            <button class="button"
                                    data-wp-on-async--click="actions.showTeamToggle"
                                    aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                            >
                                <?php esc_html_e( 'Close Team Name', 'escapeout-game' ); ?>
                            </button>
                        </div>

                    </li>
                </ul>
                <div class="red-alert" data-wp-text="state.errorMessage"></div>

                <div style="text-align:center;">
                    <button class="button"
                            data-wp-bind--aria-expanded="context.isOpen"
                            data-wp-bind--hidden="state.showLocationWarning"
                            data-wp-on-async--click="actions.gameStart"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                            style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                    >
                        <?php esc_html_e( 'Start Game', 'escapeout-game' ); ?>
                    </button>
                </div>


                <div>
                    <div class="modalContainerMap" data-wp-class--showmodal="state.showLocationWarning">
                        <div class="modal from-right">
                            <header class="modal_header">
                                <div><strong><?php echo $attributes['gameName']?></strong></div>
                            </header>
                            <div style="text-align:center;">
                                <div style="text-align:center; font-weight:bold;font-size: 1.4em; margin-top:20px; line-height: 1.5em;"><?php echo $attributes['gameIntro'] ?></div>
                                <div style="text-align:center; font-weight:bold; font-size: 1.2em; margin-top:20px; line-height: 1.3em;">Mission: <?php echo $attributes['mission'] ?></div>

                                <div class="red-alert" style="text-align:center; margin-top:10px;"><strong>Are you ready?</strong></div>
                                <div class="red-alert" style="text-align:center; margin:10px 0;"><strong>Are you near the Center of Zone 1?</strong></div>
                                <div style="text-align: center"><?php echo wp_get_attachment_image( $attributes['playZones'][0]["imageID"], "thumbnail", "", array( "class" => "img-responsive" ) );  ?></div>

                                <button class="button"
                                        data-wp-bind--aria-expanded="context.isOpen"
                                        data-wp-on-async--click="actions.gameStart"
                                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                        style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                                >
                                    <?php esc_html_e( 'Start Game - Time Starts', 'escapeout-game' ); ?>
                                </button>
                                <button class="button"
                                        data-wp-bind--aria-expanded="context.isOpen"
                                        data-wp-on-async--click="actions.hideLocationWarning"
                                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                        style="background-color:<?php echo $attributes['textColor'];?>; color:<?php echo $attributes['bgColor']?>"
                                >
                                    <?php esc_html_e( 'No, Start Game Later', 'escapeout-game' ); ?>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>






                <div class="alert-container2" data-wp-bind--hidden="!state.alertStartVisible">
                    <div class='alert-inner'>You are currently playing another game:<br/>
                        <div class="italics" data-wp-text="state.anotherGame"></div>
                        You can only play one game at a time, do you want to play that game?<br />
                        <button class="button"
                                data-wp-on--click="actions.quitAlertStartClose"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        >
                            <?php esc_html_e( 'Play Other Game', 'escapeout-game' ); ?>
                        </button>

                        <br />Or would you like to play this game?<br />
                        <button class="button"
                                data-wp-on--click="actions.quit"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        >
                            <?php esc_html_e( 'Play this Game', 'escapeout-game' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end user should be logged in -->



        <div>
            <div class="modalContainerMap" data-wp-class--showmodal="state.modalPublicImageOpen" data-wp-on--click="actions.togglePublicImage">
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>First Zone - Image of Center</strong></div>
                    </header>
                    <main class="modal_content">
	        <?php echo wp_get_attachment_image( $attributes['playZones'][0]["imageID"], "thumbnail", "", array( "class" => "img-responsive" ) );  ?>
                    </main>
                    <footer class="modal_footer">
                        <button class="modal-close">Close</button>
                    </footer>
                </div>
            </div>
        </div>
        <div>
            <div class="modalContainerMap" data-wp-class--showmodal="state.showGameScore" >
                <div class="modal from-right">
                    <header class="modal_header">
                       Game Complete
                    </header>
                    <main class="modal_content">
                        <div data-wp-bind--hidden="!context.userMustBeLoggedIn">
                           <h3 style="margin-top:0">Great Job <br /><span data-wp-text="context.teamName"></span>!</h3>
                        </div>
                        <div class="show-score" >
                            Game Score: <span class="game-score" data-wp-text="state.gameScore"></span> mins<br />
                            Hint Time: <span class="game-score" data-wp-text="callbacks.hintTime"></span> mins<br />
                            <div data-wp-bind--hidden="!context.userMustBeLoggedIn">
                                <div class="small" data-wp-bind--hidden="!action.checkFirstTime">
                                    Awesome! This score qualifies for the Leaderboard!
                                </div>
                                <div  class="small" data-wp-bind--hidden="action.checkFirstTime">
                                    This score does not qualify for the leaderboard but hopefully the game was fun.
                                </div>
                            </div>
                            <div data-wp-bind--hidden="!context.userMustBeLoggedIn">
                             Please Rate:<br />
                            <button data-wp-on--click="actions.setRating1" class="ratings" id="rating1">1</button>
                            <button data-wp-on--click="actions.setRating2" class="ratings" id="rating2">2</button>
                            <button data-wp-on--click="actions.setRating3" class="ratings" id="rating3">3</button>
                            <button data-wp-on--click="actions.setRating4" class="ratings" id="rating4">4</button>
                            <button data-wp-on--click="actions.setRating5" class="ratings" id="rating5">5</button><br /><br />
                            Public Comment:<br />
                            <textarea
                                    class="escapeout-game__textarea text-area"
                                    id="gameCommentPublic"
                                    name="feedback"
                                    placeholder="<?php esc_html_e( 'Your Public Comment', 'escapeout-game' ); ?>"
                                    required
                                    rows="4"
                                    spellcheck="false"
                            ></textarea><br /><br />
                            Private Comment:<br />
                            <textarea
                                    class="escapeout-game__textarea text-area"
                                    id="gameCommentPrivate"
                                    name="feedback"
                                    placeholder="<?php esc_html_e( 'Your Private Comment', 'escapeout-game' ); ?>"
                                    required
                                    rows="4"
                                    spellcheck="false"
                            ></textarea><br />
                            <button data-wp-on--click="actions.saveGameComments" class="modal-close">submit comments</button>
                            <hr />
                            </div>
                        </div>

                    </main>
                    <footer class="modal_footer">
                        <button data-wp-on--click="actions.closeGameScore" class="modal-close">Close</button>
                    </footer>
                </div>
            </div>
        </div>
        <div>
            <div class="modalContainerMap" data-wp-class--showmodal="state.modalStatsOpen" data-wp-on--click="actions.toggleStats">
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>Stats</strong></div>
                    </header>
                    <main class="modal_content">
                        <div class="flex-table header">
                            <div class="flex-row fifths first">team name</div>
                            <div class="flex-row fifths">score (mins)</div>
                            <div class="flex-row fifths">hint time</div>
                            <div class="flex-row fifths">date</div>
                            <div class="flex-row fifths">rating</div>
                        </div>
		                <?php
		                foreach($resultStats as $score) { ?>
                            <div class="flex-table row">
                                <div class="flex-row fifths"><?php echo $score->teamName ?></div>
                                <div class="flex-row fifths"><?php echo $score->totalTime ?></div>
                                <div class="flex-row fifths"><?php echo $score->hintTime ?></div>
                                <div class="flex-row fifths"><?php echo $score->formattedDate ?></div>
                                <div class="flex-row fifths"><?php echo $score->gameRating ?></div>
                            </div>
                            <div class="comment-row">
                                <?php if ($score->gameCommentPrivate) {
                                        echo "<strong>private comment</strong>: " . $score->gameCommentPrivate;
                                } ?>
                            </div>
                            <div class="comment-row">
				                <?php if ($score->gameCommentPublic) {
					                echo "<strong>public comment</strong>: " . $score->gameCommentPublic;
				                } ?>
                            </div>
			                <?php } ?>
                    </main>
                    <footer class="modal_footer">
                        <button class="modal-close">Close</button>
                    </footer>
                </div>
            </div>
        </div>
        <div>
            <div class="modalContainerMap" data-wp-class--showmodal="state.modalLeaderBoardOpen" data-wp-on--click="actions.toggleLeaderBoard">
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>Leaderboard</strong></div>
                    </header>
                    <main class="modal_content">
                        <div class="flex-table header">
                            <div class="flex-row fourths first">rank</div>
                            <div class="flex-row fourths first">team name</div>
                            <div class="flex-row fourths">score (mins)</div>
                            <div class="flex-row fourths">hint time</div>
                            <div class="flex-row fourths">date</div>
                        </div>
                          <?php
                          $index = 1;
                          foreach($resultLeaderBoard as $score) { ?>
                                <div class="flex-table row">
                                    <div class="flex-row fourths"><?php echo $index ?></div>
                                    <div class="flex-row fourths"><?php echo $score->teamName ?></div>
                                    <div class="flex-row fourths"><?php echo $score->totalTime ?></div>
                                    <div class="flex-row fourths"><?php echo $score->hintTime ?></div>
                                    <div class="flex-row fourths"><?php echo $score->formattedDate ?></div>
                                </div>
                           <?php $index++; } ?>
                    </main>
                    <footer class="modal_footer">
                        <button class="modal-close">Close</button>
                    </footer>
                </div>
            </div>
        </div>
        <div>
            <div class="modalContainerMap" data-wp-class--showmodal="state.modalCommentsOpen" data-wp-on--click="actions.toggleComments">
                <div class="modal from-right">
                    <header class="modal_header">
                        <div><strong>Comments/Ratings</strong> (only people who have completed game can comment and rate)</div>
                    </header>
                    <main class="modal_content">
                        <div class="flex-table header">
                            <div class="flex-row  first">Team Name</div>
                            <div class="flex-row first">Comment</div>
                            <div class="flex-row  first">Rating</div>
                            <div class="flex-row  first">Testing?</div>
                            <div class="flex-row ">date</div>
                        </div>
                        <?php
                        $index = 1;
                        foreach($resultComments as $comment) { ?>
                            <div class="flex-table row">
                                <div class="flex-row"><?php echo $comment->teamName ?></div>
                                <div class="flex-row"><?php echo $comment->gameCommentPublic  ?></div>
                                <div class="flex-row"><?php echo $comment->gameRating ?></div>
                                <div class="flex-row "><?php echo $comment->testing ?></div>
                                <div class="flex-row "><?php echo $comment->formattedDate ?></div>
                            </div>
                            <?php $index++; } ?>
                    </main>
                    <footer class="modal_footer">
                        <button class="modal-close">Close</button>
                    </footer>
                </div>
            </div>
        </div>

    </div><!-- end game start bar - hidden while playing game -->


    <div class="modalContainer2 gameModal"
         data-wp-class--showmodal="context.gameStart" >
        <div class="modal from-top">
            <div class="game-container"
                 style="background-color:<?php echo $attributes['bgColor']?>"
                 data-wp-class--dark-theme="state.isDark"
	            <?php //echo wp_interactivity_data_wp_context( $gameContext); ?>>
                <div style="text-align:center; font-weight:bold; font-size: 1.2em;">Mission: <span class="mission" data-wp-text="context.mission"></span></div>

                <div class="button-bar">
                    <!-- check if gameMap (context true/false -> added a game map block and created an anchor) -->
                    <!-- <a href="#gameMap" class="button">Zone Map</a>-->
                    <button class="button"
                            data-wp-bind--hidden="callbacks.checkPublicMap"
                            data-wp-on-async--click="actions.togglePublicMap"
                            aria-controls="<?php echo esc_attr( $unique_id );?>"
                     >
                        <?php esc_html_e( 'Zone Map', 'escapeout-game' ); ?>
                    </button>
                    <button class="button"
                            data-wp-on--click="actions.toggleTheme"
                            data-wp-text="state.themeText">

                    </button>
                    <button class="button"
                            data-wp-on--click="actions.quitAlertOpen"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                    >
                        <?php esc_html_e( 'Quit', 'escapeout-game' ); ?>
                    </button>
                </div>
                <div class="puzzle-solved" data-wp-context='{ "counter": 0 }' data-wp-watch="callbacks.logCounter">
                    Puzzles Solved? <span data-wp-text="state.solvedArray.length"></span>/<span data-wp-text="state.puzzleQuestionArray.length"></span>
                    <!--<button data-wp-on--click="actions.increaseCounter">+</button>
                    <button data-wp-on--click="actions.decreaseCounter">-</button>-->
                </div>
                <div aria-label="Time" class="time">
                    <div class="small">time started: <span data-wp-text="state.formattedDate"></span> | hint time: <span data-wp-text="callbacks.hintTime"></span> </div>
                </div>
                <div class="item-header" >Zone
                     <img data-wp-on--click="actions.setZoneHelpVisible" class="question"  data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark"   src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />
                </div>
                <div class="zone-name" data-wp-text="state.zoneName"></div>
                <div class="zone-holder">
                    <?php $indexZone=1;
                    foreach($gameContext['playZones'] as $playZone) { ?>
                        <div data-wp-on--click="actions.setZoneVisible" <?php echo wp_interactivity_data_wp_context($playZone) ?> data-wp-class--zone-border="callbacks.zoneBorder" class="zone-icon-container">
                            <img src="<?php echo $siteUrl . $assetDir . "zone.svg" ?>" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" alt="<?php echo $playZone['name'] ?>" />
                            <div class="zone-text">Zone: <?php echo $indexZone; ?></div>
                        </div>

                    <?php $indexZone++; } ?>
                </div>
                <div class="zone-description" data-wp-text="state.zoneDescription" data-wp-bind--hidden="!callbacks.zoneDescription"></div>
                <?php foreach($gameContext['playZones'] as $playZone) { ?>
                    <div class="zone-image" <?php echo wp_interactivity_data_wp_context($playZone) ?>>
                        <div data-wp-bind--hidden="callbacks.hideItemByZone">
                            <?php echo wp_get_attachment_image( $playZone["imageID"], "thumbnail", "", array( "class" => "img-responsive" ) );  ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="item-header">Puzzles
                    <img data-wp-on--click="actions.setPuzzleHelpVisible" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" class="question" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />
                </div>
                <div class="puzzle-holder">
                    <?php $puzIndex = 0;foreach($gameContext['puzzleArray'] as $puzzle) { ?>
                    <div  <?php echo wp_interactivity_data_wp_context($puzzle) ?>>
                        <div data-wp-bind--hidden="callbacks.hideItemByZone">
                            <div>
                                <div class="puzzle-item" data-wp-on--click="actions.setPuzzleModalVisible"  data-wp-bind--hidden="callbacks.checkSolved">
                                    <img data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $puzzle["iconPath"] . ".svg" ?>" alt="<?php echo $puzzle["name"] ?>" />
                                </div>
                                <div class="puzzle-item" data-wp-bind--hidden="!callbacks.checkSolved">
                                    <img data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $puzzle["iconPath"] . "-open.svg" ?>" alt="<?php echo $puzzle["name"] ?>" />
                                    <div><?php echo $puzzle['clue'] ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- puzzle modal / puzzle needs an id-->

                        <div>
                            <div class="modalContainerPuzzle" data-wp-class--showmodal="callbacks.puzzleOpen" data-wp-bind--hidden="context.solved">
                                <div class="modal from-right">
                                    <header class="modal_header">
                                        <div data-wp-text="state.puzzleName"></div>
                                    </header>
                                    <main class="modal_content">
                                        <div data-wp-text="state.puzzleQuestion"></div>
                                        <label><?php //echo $quesArray[$puzIndex][$puzzle["puzzleID"]] ?></label><br />
                                        <input
                                                id="<?php echo $puzzle["puzzleID"] ?>"
                                                aria-invalid="false"
                                                type="text"
                                                value="<?php echo $puzzle["guess"] ?>"
                                        /><br />
                                        <button data-wp-on--click="actions.guessAttempt" class="button check-answer">check answer</button>
                                        <div class="correct-message" data-wp-class--correct-message--visible="context.solved">
                                            <img src="<?php echo $siteUrl . $assetDir . "happy.svg" ?>" alt="correct" />
                                            <p>Correct Answer!</p>
                                        </div>
                                        <div class="incorrect-message" data-wp-class--incorrect-message--visible='context.showSorry'>
                                            <img src="<?php echo $siteUrl . $assetDir . "sad.svg" ?>" alt="wrong" />
                                            <p>Sorry, try again.</p>
                                        </div>
                                    </main>
                                    <footer class="modal_footer">
                                        <button data-wp-on--click="actions.setPuzzleModalHidden" class="modal-close">close puzzle</button>
                                    </footer>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php $puzIndex++; } ?>
                </div>
                <div class="item-header">Clues
                    <img data-wp-on--click="actions.setClueHelpVisible" class="question" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />

                </div>
                <div class="clue-holder">
                    <?php foreach($gameContext['clueArray'] as $clue) { ?>
                        <div class="clue-item"  <?php echo wp_interactivity_data_wp_context($clue) ?> data-wp-bind--hidden="callbacks.hideItemByZone">
                                <div >
                                    <div data-wp-on--click="actions.setClueDisplayToggle" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark">
                                      <img src="<?php echo $siteUrl . $clue["iconPath"] . ".svg" ?>" alt="<?php echo $clue["name"] ?>" />
                                    </div>
                                    <div class="clue-item-text" data-wp-bind--hidden="!callbacks.clueDisplayOn">
                                        <div><?php //echo $clueTextArray[$clueIndex][$clue["clueID"]] ?></div>
                                        <div data-wp-text="state.clueText"></div>
                                        <div data-wp-bind--hidden="!context.clueHasImage" data-wp-on--click="actions.setClueBigImageToggle">
                                            <?php echo wp_get_attachment_image( $clue["imageID"], "thumbnail", "", array( "class" => "img-responsive" ) );  ?>
                                        </div>
                                        <button class="button"
                                                data-wp-on--click="actions.setClueDisplayOff"
                                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                        >
                                            <?php esc_html_e( 'Close Clue', 'escapeout-game' ); ?>
                                        </button>
                                    </div>
                                </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="item-header">Hints
                    <img data-wp-on--click="actions.setHintHelpVisible" class="question" data-wp-class--icon-black="!state.isDark" data-wp-class--icon-white="state.isDark" src="<?php echo $siteUrl . $assetDir . "question.svg" ?>" alt="question about zones" />

                </div>
                <div class="hint-holder">
                    <?php foreach($gameContext['hintArray'] as $hint) { ?>
                        <div  <?php echo wp_interactivity_data_wp_context($hint) ?> data-wp-bind--hidden="callbacks.hideItemByZone">
                            <div style="text-align:center">
                                <button class="button"
                                        data-wp-on--click="actions.setHintDisplayOn"
                                        aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                >
                                    <?php echo $hint["name"] ?>
                                </button>
                                <div class="hint-item" data-wp-bind--hidden="!callbacks.hintDisplayOn">
                                    <div data-wp-text="state.hintText"></div>
                                    <div><?php //echo $hintTextArray[$hintIndex][$hint["hintID"]] ?></div>
                                    <button class="button"
                                            data-wp-on--click="actions.setHintDisplayOff"
                                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    >
                                        <?php esc_html_e( 'Close Hint', 'escapeout-game' ); ?>
                                    </button>
                                </div>
                            </div>

                            <div class="alert-container" data-wp-bind--hidden="!callbacks.hintWarningVisible">
                                <div class='alert-inner'>Do You Really Want To See Hint? It adds 5 minutes to your score.<br/>
                                    <button class="button"
                                            data-wp-on--click="actions.openHint"
                                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    >
                                        <?php esc_html_e( 'Yes', 'escapeout-game' ); ?>
                                    </button>
                                    <button class="button"
                                            data-wp-on--click="actions.quitWarningClose"
                                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                                    >
                                        <?php esc_html_e( 'No', 'escapeout-game' ); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                </div>

            </div><!-- end game-container -->
            <div class="help-container" data-wp-bind--hidden="!state.helpVisible">
                <div class='help-inner' style="background-color:<?php echo $attributes['bgColor']?>">
                    <header class="modal_header">
                        <div><strong>Help</strong></div>
                    </header>
                    <div data-wp-bind--hidden="!state.zoneHelpVisible"><strong>Zones</strong><br /><?php echo $attributes["zoneText"] ?></div>
                    <div data-wp-bind--hidden="!state.puzzleHelpVisible"><strong>Puzzles</strong><br /><?php echo $attributes["puzzleText"] ?></div>
                    <div data-wp-bind--hidden="!state.clueHelpVisible"><strong>Clues</strong><br /><?php echo $attributes["clueText"] ?></div>
                    <div data-wp-bind--hidden="!state.hintHelpVisible"><strong>Hints</strong><br /><?php echo $attributes["hintText"] ?></div>

                    <footer class="modal_footer">
                        <button class="button"
                                data-wp-on--click="actions.closeHelp"
                                aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                        >
                            <?php esc_html_e( 'Close Help', 'escapeout-game' ); ?>
                        </button>
                    </footer>

                </div>
            </div>
            <div class="alert-container" data-wp-bind--hidden="!state.alertVisible">
                <div class='alert-inner' data-wp-text="state.alertText"></div>
            </div>
            <div class="alert-container" data-wp-bind--hidden="!state.quitVisible">
                <div class='alert-inner'>Do You Really Want To Quit?<br/>
                    <button class="button"
                            data-wp-on--click="actions.quit"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                    >
                        <?php esc_html_e( 'Yes', 'escapeout-game' ); ?>
                    </button>
                    <button class="button"
                            data-wp-on--click="actions.quitAlertClose"
                            aria-controls="<?php echo esc_attr( $unique_id ); ?>"
                    >
                        <?php esc_html_e( 'No', 'escapeout-game' ); ?>
                    </button>
                </div>
            </div>


            </div>
        </div>
    <div>
        <div class="modalContainerMap" data-wp-class--showmodal="state.modalPrivateMapOpen" data-wp-on--click="actions.togglePrivateMap">
            <div class="modal from-right">
                <header class="modal_header">
                    <div><strong>Zone Map</strong> <span class="small">(click on right arrow or icons for zone name(s))</span> </div>
                </header>
                <main id="privateMapContainer" class="modal_content">

                </main>
                <footer class="modal_footer">
                    <button class="modal-close">Close</button>
                </footer>
            </div>
        </div>
    </div>
    <div>
        <div class="modalContainerMap" data-wp-class--showmodal="state.modalPublicMapOpen" data-wp-on--click="actions.togglePublicMap">
            <div class="modal from-right">
                <header class="modal_header">
                    <div><strong>Public Map</strong></div>
                </header>
                <main id="publicMapContainer" class="modal_contentr">

                </main>
                <footer class="modal_footer">
                    <button class="modal-close">Close</button>
                </footer>
            </div>
        </div>
    </div>
</div><!-- end game-block-frontend -->
