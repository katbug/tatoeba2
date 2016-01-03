<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */

$username = Sanitize::paranoid($username, array("_"));
$title = format(__("{user}'s favorite sentences", true), array('user' => $username));
$this->set('title_for_layout', $pages->formatTitle($title));
$numberOfSentences = count($favorites);
?>

<div id="annexe_content">
    <?php
        echo $this->element(
        'users_menu', 
        array('username' => $username)
    );
    ?>
</div>

<div id="main_content">
    <div class="module">
    
    <h2><?php echo $title . ' ('. $numberOfSentences.')'; ?></h2>
    
    <?php
    
    if ($numberOfSentences > 0) {
        $type = 'mainSentence';
        $parentId = null;
        $withAudio = false;
        $ownerName = null;
        foreach ($favorites as $favorite) {
            if (empty($favorite['Sentence']['text'])) {
                $sentenceId = $favorite['Favorite']['favorite_id'];
                $linkToSentence = $html->link(
                    '#'.$sentenceId,
                    array(
                        'controller' => 'sentences',
                        'action' => 'show',
                        $sentenceId
                    )
                );

                echo $html->div('sentence deleted',
                    format(
                        __('Sentence {id} has been deleted.', true),
                        array('id' => $linkToSentence)
                    )
                );
            } else {
                $sentences->displayGenericSentence(
                    $favorite['Sentence'],
                    $favorite['Sentence']['Transcription'],
                    $type,
                    $parentId,
                    $withAudio
                );
            }
        }
    } else {
        __('This user does not have any favorites.');
    }
    ?>
    </div>
</div>
