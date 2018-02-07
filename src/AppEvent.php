<?php
/**
 * Created by PhpStorm.
 * User: jeremyclerot
 * Date: 20/12/2017
 * Time: 11:53
 */

namespace App;


class AppEvent
{
    const ARTICLE_ADD    = "article_add";
    const ARTICLE_EDIT    = "article_edit";
    const ARTICLE_DELETE    = "article_delete";

    const TRAINING_ADD    = "training_add";
    const TRAINING_EDIT    = "training_edit";
    const TRAINING_DELETE   = "training_delete";

    const COMMENT_ADD    = "comment_add";
    const COMMENT_DELETE   = "comment_delete";

    const VOTE_ADD    = "vote_add";
    const VOTE_DELETE   = "vote_delete";

    const MEDIA_ADD    = "media_add";
    const MEDIA_EDIT    = "media_edit";
    const MEDIA_DELETE   = "media_delete";

    const ADMIN_BLOCK    = "admin_block";
    const ADMIN_DEBLOCK    = "admin_deblock";
    const ADMIN_DELETE    = "admin_delete";
}