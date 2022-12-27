<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Preprocessing\ChatPart;

enum ChatEventType: string
{
    case ADD_USER = "CHATEVENT_ADDUSER";
    case JOIN = "CHATEVENT_JOIN";
    case LEAVE = "CHATEVENT_LEAVE";
    case REMOVE_USER = "CHATEVENT_REMOVEUSER";
    case SET_CHATNAME = "CHATEVENT_SETCHATNAME";
    case SET_NICKNAME = "CHATEVENT_SETNICKNAME";
}
