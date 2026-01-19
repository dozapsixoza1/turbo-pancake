<?php
require 'db.php';
include "vk_api.php";
include 'chat_settings.php';
include 'user_registation.php';
const VK_KEY = "vk1.a.s5oVKIWouS0da1goPzSwK1fYWc7BHKj_zpoq1kceODdD_Sh5lT8zji37xWqssN11Vw2tFo8BWs88ddPYyJL36RoX_JQbW6ZXfvt2fNqhdNVrGhcYJ3mO3yCQwI7hnI9NAHl5pqgzZKGLEn3iwA1msPHLIrne1relgPU-i799u7BSHum9BDzkQ70QEHnAm3uTCLTujPQ3UAqFkG9sQcpbEg"
const GROUP_ID = 235436178
const VERSION = "5.81";
const ACCESS_KEY = "a1f6ab3e";  // Ключ подтверждения

$vk = new vk_api(VK_KЕY, VERSION);
$data = json_decode(file_get_contents('php://input'));
if ($data->type == 'confirmation') {
    exit(ACESS_KEY); // Отправляем ключ подтверждения
}
// Обработка других событий (если это не подтверждение)
$vk->sendOK(); // Отправляем "ok" на другие события
// ---------- Переменные ----------
$peer_id = $daa->object->peer_id;
$id = $data->object->from_id;
$chat_id = $peer_id - 2000000000;
$is_admin = [865505970]; // создаем массив с ID's наших будущих админов через запятую
// ---------- Сообщение ----------
$message = $data->object->text;
$messages = explode(" ", $message);
$cmd = $messages[0]; // Сохраняем исходное сообщение

if (strpos(d, '/') !== false || strpos($cmd, '!') !== false) {
    // Если сообщение содержит символы "/" или "!", выполняем приведение к нижнему регистру и удаление символов
    $cmd = mb_strtolower(preg_replace('/[\/!]/u', '', $cmd));
} else {
    // Если сообщение не содержит символы "/", "!", добавляем символ "+"
    $cmd .= '+';
}
$args = array_slice($messages, 1);
// ---------- Другое ----------
$reply_message = $data->object->reply_message; // Получение ответного сообщения
$reply_author = $data->object->reply_message->from_id; // Получение ID автора ответного сообщения
$chat_act = $data->object->action; // Получение действия (если есть)
$fwd_messages = $data->object->fwd_messages;


    }

if (in_array($cmd, ['vladelec'])) {
    if ($id == 678695202 || $id == 50776517)  {
    $lvladmin = 2222;
        
    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
    if ($userAdminInfoTr) {
    
    $userAdminInfoTr['lvl'] = $lvladmin;
    R::store($userAdminInfoTr);
    } else {
    $newUserAdmin = R::dispense('usersadmin');
    $newUserAdmin->user_id = $id;
    $newUserAdmin->beda_id = $chat_id;
    $newUserAdmin->lvl = $lvladmin;
    R::store($newUserAdmin);
    }
        
    forwardMessage($vk, $peer_id, $messageIdToReply, "Мой повелитель, Вам были выданы Ваши права.");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Владельцу Blue.");
        }
    }

if ($cmd == 'sysrole') {
    // Проверяем уровень доступа администратора
    if ($adminCheck['lvl'] <= 2221) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        return; // Прерываем выполнение команды
    } else {
        // Проверяем, что команда выполняется в чате администрации бота
        if (count($args) >= 2) {
            $target = $args[0]; // Упоминание целевого пользователя
            $adminLevel = intval(end($args)); // Получаем последний аргумент как уровень админки
    
            // Получаем ID целевого пользователя из упоминания
            preg_match('/\[id(\d+)\|.*\]/', $target, $matches);
            if (isset($mes[1])) {
                $targetUserId = (int)$matches[1];
            } else {
                preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches);
                if (isset($matches[1])) {
                    $targetUserId = (int)$matches[1];
                } else {
                    preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches);
                    if (isset($matches[1])) {
                        $username = $matches[1];
                        $userInfo = $vk->request('utils.resolveScreenName', [
                            'screen_name' => $username,
                        ]);
                        if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                            $targetUserId = $userInfo['object_id'];
                        }
                    }
                }
            }
    
            if (isset($targetUserId)) {
                // Проверяем, существует ли роль с указанным приоритетом
                $role = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminLevel]);
    
                if ($role) {
                    // Получаем имя роли из таблицы settingsrole
                    $roleName = $role->roles;
    
                    // Получаем информацию о целевом пользователе
                    $userinInfo = R::fine('usersadmin', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);
    
                    // Проверяем, что администратор, которому мы хотим установить уровень,
                    // не имеет более высокий уровень, чем текущий администратор
                    /*if ($adminLevel >= $adminCheck['lvl']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете установить роль с приоритетом выше или равным собственному.");
                        return; // Прерываем выполнение команды
                    }
                    if ($userAdminInfo && $adminCheck['lvl'] <= $userAdminInfo->lvl) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете изменить роль пользователя с приоритетом выше или равным собственному.");
                        return;
                    }*/
                    if (!$userAdminInfo) {
                        // Указанный пользователь ещё не имеет админских прав в этой беседе
                        $userAdminInfo = R:ispene('usersadmin');
                        $userAdminInfo->user_id = $tgetUserId;
                        $userAdnInfo->beseda_id = $cht_id;
                        $userAdinInfo->lvl = $admevel;
                        R::store($userAdminInfo);
    
                        // Оповещение
                        $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                        $targetUserInfo = R::findOne('users', 'user_id = ?', [$targetUserId]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|{$adminInfo->nick}] назначил [id{$targetUserId}|{$targetUserInfo->nick}] на роль '$roleName'.");
                    } else {
                        // Указанный пользователь уже имеет админские права в этой беседе, обновляем уровень
                        $userAdminInfo->lvl = $adminLevel;
                        R::store($userAdminInfo);
    
                        // Оповещение
                        $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                        $targetUserInfo = R::findOne('users', 'user_id = ?', [$targetUserId]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|{$adminInfo->nick}] обновил приоритет [id{$targetUserId}|{$targetUserInfo->nick}] до роли '$roleName'.");
                    }
                } else {
                    // Если роль с указанным приоритетом не найдена
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Роль с приоритетом '$adminLevel' не найдена.");
                }
            } else {
                Message($vk, $peer_id, $messageIdToReply, "Ошибка при определении пользователя.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /sysrole [упоминание пользователя] [приоритет]");
        }
    }
}

if (in_array($cmd, ['ruk'])) {
    if ($Ruk) {
    $lvladmin = 1111;
    
    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
    if ($userAdminInfoTr) {

    $userAdminInfoTr['lvl'] = $lvladmin;
    R::store($userAdminInfoTr);
    } else {
    $Admin = R::dispense('usersadmin');
    $Admin->user_id = $id;
    $Admin->beseda_id = $chat_id;
    $Admin->lvl = $lvladmin;
    R::store($newUserAdmin);
    }
    
    forwardMessage($vk, $peer_id, $messageIdToReply, "Мой повелитель, Вам были выданы Ваши права.");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Руководителю Blue.");
        }
    }

if (in_array($cmd, ['dev'])) {
    if ($Dev) {
    $lvladmin = 5550;
    
    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
    if ($userAdminInfoTr) {

    $userAdminInfoTr['lvl'] = $lvladmin;
    R::store($userAdminInfoTr);
    } else {
    $newUserAdmin = R::dispense('usersadmin');
    $newUserAdmin->user_id = $id;
    $newUsin->beseda_id = $chat_id;
    $newUserAdmin->lvl = $lvladmin;
    R::store($newUserAdmin);
    }
    
    forwardMessage($vk, $peer_id, $mesIdToReply, "Мой повелитель, Вам были выданы Ваши права.");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Разработчику Blue.");
        }
    }

if (in_array($cmd, ['admin'])) {
    if ($Admin) {
    $lvladmin = 400;
    
    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
    if ($userAdminInfoTr) {

    $userAdminInfoTr['lvl'] = $lvladmin;
    R::store($userAdminInfoTr);
    } else {
    $newUserAdmin = R::dispense('usersadmin');
    $newUserAdmin->user_id = $id;
    $newUserAdmin->beseda_id = $chat_id;
    $newUserAdmin->lvl = $lvladmin;
    R::store($newUserAdmin);
    }
    
    forwardMessage($vk, $peer_id, $messageIdToReply, "Вам были выданы Ваши права.");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Администратору Blue.");
        }
    }

if (in_array($cmd, ['moder'])) {
    if ($Moderator) {
    $lvladmin = 111;
    
    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
    if ($userAdminInfoTr) {

    $userAdminInfoTr['lvl'] = $lvladmin;
    R::store($userAdminInfoTr);
    } else {
    $newUserAdmin = R::dispense('usersadmin');
    $newUserAdmin->user_id = $id;
    $newUserAdmin->beseda_id = $chat_id;
    $newUserAdmin->lvl = $lvladmin;
    R::store($newUserAdmin);
    }
    
    forwardMessage($vk, $peer_id, $messageIdToReply, "Вам были выданы Ваши права.");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Модератору Blue.");
        }
    }


    // Проверяем, активированы ли функции бота в данной беседе
    $chatSettings = R::findOne('settings', 'peer_id = ?', [$peer_id]);
    
    // Определяем интервал времени для антифлуда (30 секунд)
    $floodInterval = 30;
    
    if ($muteInfo) {
        // Если есть активный мут, проверяем время снятия мута
        $unmuteTime = strtotime($muteInfo->umute_time);
        
        if ($unmuteTime <= $currentTimestamp) {
            // Удаляем запись о муте из таблицы mutes
            $muteInfo = R::findOne('mutes', 'user_id = ? AND beseda_id = ?', [$user_id, $chat_id]);
            if ($muteInfo) {
                R::trash($muteInfo);
                forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$user_id}|Ваш] доступ к чату разблокирован!");
            }
        } else {
            // Время снятия мута еще не наступило, исключаем пользователя из беседы
            $vk->request('messages.delete', [
                'peer_id' => $peer_id,
                'cmids' => $message_id,
                'delete_for_all' => 1
            ]);
            // Отправляем пользователю сообщение о исключении из беседы
            $vk->sendMessage($user_id, "Ваше последнее сообщение было удалено из чата $chat_id из-за активного мута.");
            return; // Завершаем выполнение обработчика после исключения пользователя
        }
    }

    $chatSilence = R::findOne('settings', 'peer_id = ? AND silence > 0', [$peer_id]);
    if ($chatSilence) {
    // Проверяем уровень доступа пользователя
    if ($chatSilence->silence == 1 && $adminCheck['lvl'] < $chatSilence->silencelvl || ($chatSilence->silence == 3 && $adminCheck['lvl'] < 20)) {
        // Проверяем настройку режима тишины
        if ($chatSilence->silencesettings == 0) {
            // Удаляем сообщение для всех
            $vk->request('messages.delete', [
                'peer_id' => $peer_id,
                'cmids' => $message_id,
                'delete_for_all' => 1
            ]);
        } elseif ($chatSilence->silencesettings == 1) {
            // Удаляем сообщение для всех
            $vk->request('messages.delete', [
                'peer_id' => $peer_id,
                'cmids' => $message_id,
                'delete_for_all' => 1
            ]);
            // Исключаем пользователя из беседы
            $vk->request('messages.removeChatUser', [
                'chat_id' => $chat_id,
                'user_id' => $user_id,
            ]);    
            // Отправляем пользователю сообщение о исключении из беседы
            $vk->sendMessage($peer_id, "[id{$user_id}|Пользователь] был исключён из беседы из-за нарушения режима тишины.");
        } elseif ($chatSilence->silencesettings == 2) {
            // Удаляем сообщение для всех
            $vk->request('messages.delete', [
                'peer_id' => $peer_id,
                'cmids' => $message_id,
                'delete_for_all' => 1
            ]);
            // Получаем количество предупреждений пользователя
            $warnCount = R::count('userwarns', 'user_id = ? AND beseda_id = ?', [$user_id, $chat_id]);
            // Проверка, чтобы не выдать больше 3 предупреждений
            if ($warnCount >= 2) {
                // Если у пользователя есть админка, снимаем её
                if ($targetUserAdminLevel['lvl'] > 0) {
                    R::exec('DELETE FROM usersadmin WHERE beseda_id = ? AND user_id = ?', [$chat_id, $user_id]);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Административные права [id$user_id|пользователя] сняты из-за превышения предупреждений.");

                    // Теперь удаляем предупреждения пользователя из таблицы конкретной беседы
                    R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ?', [$chat_id, $user_id]);
                } else {
                    // Если у пользователя нет админки, исключаем из беседы
                    $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $user_id]);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь [id$user_id|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] исключен из беседы из-за превышения предупреждений.");

                    // Теперь удаляем предупреждения пользователя из таблицы конкретной беседы
                    R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ?', [$chat_id, $user_id]);
                }
            } else {
                // Записываем предупреждение в базу данных

 /*if ($cmd == 'start') {
    // Проверяем, есть ли уже владелец в настройках беседы
    $chat = R::findOne('settings', 'peer_id = ?', [$peer_id]);

    if ($chat && $chat->owner_id != NULL) {
        // Владелец уже назначен, отправляем сообщение об ошибке
       forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа уже активирована");

        // Проверяем, существуют ли записи в settingsrole и usersadmin для данной беседы
        $settingsRoleExists = R::findOne('settingsrole', 'beseda_id = ?', [$chat_id]);
        $usersAdminExists = R::findOne('usersadmin', 'beseda_id = ?', [$chat_id]);

        if ($settingsRoleExists && $usersAdminExists) {
            // Отправляем сообщение о восстановлении настроек
            forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки для данной беседы уже были регистрированы ранее, мы вернули их.");
        }
    } else {
        // Получаем информацию о участниках беседы
        $conversationMembers = $vk->request('messages.getConversationMembers', [
            'peer_id' => $peer_id,
        ]);

        // Проверяем, успешно ли получена информация о беседе
        if (isset($conversationMembers['items'])) {
            foreach ($conversationMembers['items'] as $member) {
                if ($member['member_id'] == $id && $member['is_owner']) {
                    // Выполняем команды для владельца беседы
                    defaultroles($chat_id, $vk, $peer_id);
                    defaultsettings($chat_id, $vk, $peer_id);

                    // Назначаем пользователю 100 уровень админки
                    $userAdminInfo = R::dispense('usersadmin');
                    $userAdminInfo->user_id = $id; // ID пользователя
                    $userAdminInfo->beseda_id = $chat_id; // ID беседы
                    $userAdminInfo->lvl = 100; // 100 уровень админки
                    R::store($userAdminInfo);

                    // Вписываем ID пользователя в owner_id для конкретной беседы
                    if ($chat) {
                        $chat->owner_id = $id;
                        R::store($chat);
                    }

                    // Отправляем сообщение о выполнении команды
                   forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа успешно активирована! \n Вы можете ввести /help (/помощь) для просмотра списка команд и документации. \n Наслаждайтесь компанией Blue | chat-manager!");
                    break;
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply,"Не удалось определить владельца беседы.");
        }
    }
}*/
if ($cmd == 'start') {
    $chat = R::findOne('settings', 'peer_id = ?', [$peer_id]);

    if ($chat && $chat->owner_id != NULL) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа уже активирована");
        $settingsRoleExists = R::findOne('settingsrole', 'beseda_id = ?', [$chat_id]);
        $usersAdminExists = R::findOne('usersadmin', 'beseda_id = ?', [$chat_id]);

        if ($settingsRoleExists && $usersAdminExists) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки для данной беседы уже были регистрированы ранее, мы вернули их.");
        }
    } else {
        $conversationMembers = $vk->request('messages.getConversationMembers', [
            'peer_id' => $peer_id,
        ]);

        if (isset($conversationMembers['items'])) {
            foreach ($conversationMembers['items'] as $member) {
                // Проверяем, является ли участник владельцем беседы или администратором
                if (($member['member_id'] == $id && $member['is_owner'])) {
                    defaultroles($chat_id, $vk, $peer_id);
                    defaultsettings($chat_id, $vk, $peer_id);

                    $userAdminInfo = R::dispense('usersadmin');
                    $userAdminInfo->user_id = $id;
                    $userAdminInfo->beseda_id = $chat_id;
                    $userAdminInfo->lvl = 100;
                    R::store($userAdminInfo);

                    // Находим реального владельца беседы
                    foreach ($conversationMembers['items'] as $potential_owner) {
                        if ($potential_owner['is_owner']) {
                            if ($chat) {
                                $chat->owner_id = $potential_owner['member_id'];
                                R::store($chat);
                            }
                            break;
                        }
                    }

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа успешно активирована! \n Вы можете ввести /help (/помощь) для просмотра списка команд и документации. \n Наслаждайтесь компанией Blue | chat-manager!");
                    break;
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply,"Не удалось определить владельца беседы.");
        }
    }
}
if (in_array($cmd, ['mkick', 'мкик'])) {
    if (isset($commandAccessLevels['mkick'])) {
        $requiredAccessLevel = $commandAccessLevels['mkick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel && $premiumStatus > 0) {
            $argsCount = count($args);
            if ($argsCount >= 1) {
                $removedUsers = [];
                $failedRemovals = [];

                // Получение имени и фамилии администратора
                $adminInfo = $vk->request('users.get', ['user_ids' => $id]);
                $adminName = "[id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}]";

                foreach ($args as $target) {
                    if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                        $trUser = (int)$matches[1];
                        $userInfo = $vk->request('users.get', ['user_ids' => $trUser]);

                        if (isset($userInfo[0])) {  
                            //Администратор, которого пытаются кикнуть, найден, проверяем его уровень      
                            $excludedUserAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);                       // 
                            $excludedUserLevel = $excludedUserAdminInfo['lvl'];
                            if ($adminCheck['lvl'] <= $excludedUserLevel) {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете исключить администратора, чей уровень выше или равен Вашему!");
                                exit;
                            }
                            $userName = "[id{$trUser}|{$userInfo[0]['first_name']} {$userInfo[0]['last_name']}]";
                            $result = $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $trUser]);
                            if ($result) {
                                $removedUsers[] = $userName;
                            } else {
                                $failedRemovals[] = $userName;
                            }
                        }
                    }
                }

                if (!empty($removedUsers)) {
                    $removedUsersMessage = "Пользователи, которые были исключены из чата:\n\n";
                    $removedUsersList = "—   " . implode("\n—   ", $removedUsers);
                    $smiley = "✂️"; // Минималистический смайл для исключения
                    forwardMessage($vk, $peer_id, $messageIdToReply, "$removedUsersMessage$removedUsersList\n\n$smiley Эти пользователи больше не с нами. $smiley\n\nАдминистратор: $adminName");
                }
                if (!empty($failedRemovals)) {
                    $failedRemovalsMessage = "Не удалось исключить пользователей:\n" . implode("\n", $failedRemovals);
                    forwardMessage($vk, $peer_id, $messageIdToReply, $failedRemovalsMessage);
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /mkick [userid1] [userid2]...");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете использовать данную команду!");
        }
    }
}

if (in_array($cmd, ['mban', 'мбан'])) {
    if (isset($commandAccessLevels['mban'])) {
        $requiredAccessLevel = $commandAccessLevels['mban'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel && $premiumStatus > 0) {
            $argsCount = count($args);
            if ($argsCount >= 2) { // 1 аргумент - user_id, 2 аргумент - причина бана
                $bannedUsers = [];
                $failedBans = [];

                // Получение имени и фамилии администратора
                $adminInfo = $vk->request('users.get', ['user_ids' => $id]);
                $adminName = "[id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}]";

                foreach ($args as $target) {
                    if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                        $trUser = (int)$matches[1];
                        $reason = isset($args[1]) ? implode(" ", array_slice($args, 1)) : 'Без причины';
                        $userInfo = $vk->request('users.get', ['user_ids' => $trUser]);

                        if (isset($userInfo[0])) {
                            // Администратор, которого пытаются забанить, найден, проверяем его уровень
                            $excludedUserAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                            $excludedUserLevel = $excludedUserAdminInfo['lvl'];
                            if ($adminCheck['lvl'] <= $excludedUserLevel) {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете забанить администратора, чей уровень выше или равен Вашему!");
                                exit;
                            }
                            $userName = "[id{$trUser}|{$userInfo[0]['first_name']} {$userInfo[0]['last_name']}]";
                            $result = $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $trUser]);
                            if ($result) {
                                $bannedUsers[] = $userName;

                                // Логирование блокировки в базу данных
                                $banLog = R::dispense('banusers');
                                $banLog->user_id = $trUser;
                                $banLog->ban_time = date('Y-m-d H:i:s');
                                $banLog->ban_admin = $id;
                                $banLog->beseda_id = $chat_id;
                                $banLog->reason = $reason;
                                // Установка времени снятия бана на NULL
                                $banLog->unban_time = NULL;
                                R::store($banLog);
                            } else {
                                $failedBans[] = $userName;
                            }
                        }
                    }
                }

                if (!empty($bannedUsers)) {
                    $bannedUsersMessage = "Пользователи, которые были забанены в чате:\n\n";
                    $bannedUsersList = "—   " . implode("\n—   ", $bannedUsers);
                    $smiley = "🔒"; // Минималистический смайл для блокировки
                    forwardMessage($vk, $peer_id, $messageIdToReply, "$bannedUsersMessage$bannedUsersList\n\n$smiley Эти пользователи были забанены. $smiley\n\nАдминистратор: $adminName");
                }
                if (!empty($failedBans)) {
                    $failedBansMessage = "Не удалось забанить пользователей:\n" . implode("\n", $failedBans);
                    forwardMessage($vk, $peer_id, $messageIdToReply, $failedBansMessage);
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /mban [userid1] [причина]...");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете использовать данную команду!");
        }
    }
}


if (in_array($cmd, ['kick', 'кик'])) {
  $chat_ids = array(9, 10, 11, 12);
    if(in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75){
       forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['kick'])) {
        $requiredAccessLevel = $commandAccessLevels['kick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $trUser = 0;
            $argsCount = count($args);
            if ($argsCount >= 1) {
                $target = $args[0];
                if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $trUser = $userInfo['object_id'];
                    }
                }
            } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $targetUserObj = $data->object->fwd_messages[0];
                if (isset($targetUserObj->from_id)) {
                    $trUser = (int)$targetUserObj->from_id;
                }
            }

            // Проверяем, если целевой пользователь не указан
            if (empty($trUser)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /kick [userid] или перешлите сообщение!");
            } elseif ($trUser === $user['user_id']) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы не можете кикнуть себя из беседы.");
            } else {
                // Получаем информацию об администраторе и исключаемом пользователе
                $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                $excludedUserInfo = R::findOne('users', 'user_id = ?', [$trUser]);

                // Проверяем, существует ли исключаемый пользователь в беседе
                $chatMembers = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id]);
                $chatMembersIds = array_column($chatMembers['profiles'], 'id');
                if (!in_array($trUser, $chatMembersIds)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$trUser}|Пользователь] не состоит в этой беседе.");
                    exit;
                }

                // Продолжаем выполнение команды, так как пользователь состоит в беседе

                // Получаем никнейм и имя фамилию из таблицы nickname
                $excludedUserNicknameInfo = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                $excludedUserNickname = $excludedUserNicknameInfo ? $excludedUserNicknameInfo->nickname : $excludedUserInfo['nick'];

                $adminNicknameInfo = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
                $adminNickname = $adminNicknameInfo ? $adminNicknameInfo->nickname : $adminInfo['nick'];

                // Проверяем уровень администратора, который пытается выполнить кик
                $adminLevel = $adminCheck['lvl'];

                // Получаем уровень администратора, которого пытаются кикнуть
                $excludedUserAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);

                if (!$excludedUserAdminInfo) {
                    // Если администратор, которого пытаются кикнуть, не найден, то можно выполнить кик
                    // Формируем оповещение
                    $message = "[id{$adminInfo['user_id']}|{$adminNickname}], исключил из чата [id{$excludedUserInfo['user_id']}|{$excludedUserNickname}].";
                    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
                    if($forum){
                                $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                                if ($findTrUser && $findTrUser['forumacc']) {
                                    // Снимаем пользователю покраску
                                    try {
                                        $result = updateUserGroup($findTrUser['forumacc'], 3, $forum['forum_url'], $forum['api_key']); // 0 - это ID группы без покраски
                                        if ($result) {
                                            $vk->sendMessage($peer_id, "Покраска снята.");
                                        }
                                    } catch (Exception $e) {
                                        $vk->sendMessage($peer_id, "Произошла ошибка при снятии покраски на форуме: " . $e->getMessage());
                                    }
                                }
                            }
                    // Выполняем исключение пользователя из беседы
                    $result = $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $trUser]);
                    if ($result) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось исключить пользователя. Пожалуйста, проверьте правильность ID пользователя и вашей административной роли.");
                    }

                    // Удаление записи пользователя из таблицы nickname конкретной беседы
                    $chatId = $chat_id;
                    $userNicknameRecord = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                    if ($userNicknameRecord) {
                        R::trash($userNicknameRecord);
                    }

                    // Удаление записи пользователя из таблицы usersadmin конкретной беседы
                    $userAdminRecord = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                    if ($userAdminRecord) {
                        R::trash($userAdminRecord);
                    }
                } else {
                    // Администратор, которого пытаются кикнуть, найден, проверяем его уровень
                    $excludedUserLevel = $excludedUserAdminInfo['lvl'];
                    if ($adminLevel <= $excludedUserLevel) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете исключить администратора, чей уровень выше или равен Вашему!");
                        exit;
                    } else {
                        // Уровень администратора, который выполняет кик, выше уровня кикаемого администратора
                        // Формируем оповещение
                                $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
                                if($forum){
                                $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                                if ($findTrUser && $findTrUser['forumacc']) {
                                    // Снимаем пользователю покраску
                                    try {
                                        $result = updateUserGroup($findTrUser['forumacc'], 3, $forum['forum_url'], $forum['api_key']); // 0 - это ID группы без покраски
                                        if ($result) {
                                            $vk->sendMessage($peer_id, "Покраска снята.");
                                        }
                                    } catch (Exception $e) {
                                        $vk->sendMessage($peer_id, "Произошла ошибка при снятии покраски на форуме: " . $e->getMessage());
                                    }
                                }
                            }
                        $message = "[id{$adminInfo['user_id']}|{$adminNickname}], исключил из чата [id{$excludedUserInfo['user_id']}|{$excludedUserNickname}].\n";

                        // Выполняем исключение пользователя из беседы
                        $result = $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $trUser]);

                        if ($result) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                        }

                        // Удаление записи пользователя из таблицы nickname конкретной беседы
                        $chatId = $chat_id;
                        $userNicknameRecord = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                        if ($userNicknameRecord) {
                            R::trash($userNicknameRecord);
                        }

                        // Удаление записи пользователя из таблицы usersadmin конкретной беседы
                        $userAdminRecord = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                        if ($userAdminRecord) {
                            R::trash($userAdminRecord);
                        }
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно для Вас!");
        }
    }
}
if (in_array($cmd, ['kickfrom'])) {
    if (isset($commandAccessLevels['kickfrom'])) {
        $requiredAccessLevel = $commandAccessLevels['kickfrom'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel /*&& $premiumStatus > 0*/) {
            $trUser = 0;
            $argsCount = count($args);
            if ($argsCount >= 1) {
                $target = $args[0];
                if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $trUser = $userInfo['object_id'];
                    }
                }
            } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $targetUserObj = $data->object->fwd_messages[0];
                if (isset($targetUserObj->from_id)) {
                    $trUser = (int)$targetUserObj->from_id;
                }
            }

            if ($trUser) {
                $chatMembers = $vk->request('messages.getConversationMembers', [
                    'peer_id' => $peer_id,
                    'fields' => 'invited_by',
                ]);

                $removedUsers = [];
                foreach ($chatMembers['items'] as $chatMember) {
                    if (isset($chatMember['invited_by']) && $chatMember['invited_by'] == $trUser) {
                            //Администратор, которого пытаются кикнуть, найден, проверяем его уровень      
                            $excludedUserAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);                       // 
                            $excludedUserLevel = $excludedUserAdminInfo['lvl'];
                            if ($adminCheck['lvl'] < $excludedUserLevel) {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете исключить пользователей, приглашённых модератором, чей уровень выше вашего!");
                                exit;
                            }
                        $result = $vk->request('messages.removeChatUser', [
                            'chat_id' => $peer_id - 2000000000, // Subtract 2000000000 to get the correct chat_id
                            'user_id' => $chatMember['member_id'],
                        ]);
                        if ($result) {
                            $removedUsers[] = $chatMember['member_id'];
                        }
                    }
                }
                if (!empty($removedUsers)) {
                $invitingUser = $vk->request('users.get', ['user_ids' => $trUser]);
                $invitingUserName = "[id{$trUser}|{$invitingUser[0]['first_name']} {$invitingUser[0]['last_name']}]";

                $userList = [];
                foreach ($removedUsers as $removedUserId) {
                    if ($removedUserId > 0) {
                        $userInfo = $vk->request('users.get', ['user_ids' => $removedUserId]);
                        $userName = "[id{$removedUserId}|{$userInfo[0]['first_name']} {$userInfo[0]['last_name']}]";
                        $userList[] = $userName;
                    }
                }

                if (!empty($userList)) {
                    $message = "Участники, приглашенные $invitingUserName, были исключены из беседы:\n\n ✂️ ";
                    $usersListText = implode("\n ✂️  ", $userList);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "$message$usersListText");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось исключить пользователей, приглашенных $invitingUserName.");
                }
            }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /kickfrom [userid] или перешлите сообщение!");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна для Вас!");
        }
    }
}
if (in_array($cmd, ['q'])) {
    if ($adminCheck['lvl'] < 99) {
        // Получаем ID пользователя, отправившего команду
        $userId = $data->object->from_id;
        $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if($forum){
        $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$userId, $chat_id]);
        if ($findTrUser && $findTrUser['forumacc']) {
            // Снимаем пользователю покраску
            try {
                $result = updateUserGroup($findTrUser['forumacc'], 3, $forum['forum_url'], $forum['api_key']); // 0 - это ID группы без покраски
                if ($result) {
                    $vk->sendMessage($peer_id, "[id{$userId}|$userNicknameRecord->nickname] вышел из беседы, его покраска на форуме была снята.");
                }
            } catch (Exception $e) {
                $vk->sendMessage($peer_id, "Произошла ошибка при снятии покраски на форуме: " . $e->getMessage());
            }
        }
    }
        // Исключаем пользователя из беседы
        $result = $vk->request('messages.removeChatUser', [
            'chat_id' => $peer_id - 2000000000, // Subtract 2000000000 to get the correct chat_id
            'user_id' => $userId,
        ]);

        if ($result) {
            $invitingUser = $vk->request('users.get', ['user_ids' => $id]);
            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|{$invitingUser[0]['first_name']} {$invitingUser[0]['last_name']}] был исключён по собственному желанию!");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось исключить вас из беседы.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Будучи руководителем беседы, Вы не можете использовать эту команду.");
    }
}
// ========================= PULL SYSTEM ========================
if (in_array($cmd, ['pull'])) {
    if (isset($commandAccessLevels['pull'])) {
        $requiredAccessLevel = $commandAccessLevels['pull'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, является ли пользователь владельцем беседы
        $settings = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        $owner_id = $settings['owner_id'];

        if ($owner_id == $id) {
            // Пользователь, выполняющий команду, является владельцем текущей беседы

            // Проверяем, есть ли уже запись о pull для этого пользователя
            $pullRecord = R::findOne('pulls', 'user_id = ?', [$id]);

            if ($pullRecord) {
                // Если запись о pull существует, проверяем, есть ли беседа в списке
                $currentPull = $pullRecord['peer_ids'];
                $peerIdsArray = explode(',', $currentPull);

                if (in_array($peer_id, $peerIdsArray)) {
                    // Если беседа уже в пулле, выводим сообщение и завершаем скрипт
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Эта беседа уже находится в вашем pull.");
                    return; // Завершаем выполнение скрипта
   oReply, "В вашем pull нет включенных бесед.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа не включена в пулл!");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к данной команде!");
    }
  }
}
if (in_array($cmd, ['unpull'])) {
    if (isset($commandAccessLevels['unpull'])) {
        $requiredAccessLevel = $commandAccessLevels['unpull'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем информацию о текущей беседе
            $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

            if ($chatInfo) {
                // Получаем id владельца текущей беседы
                $ownerId = $chatInfo['owner_id'];

                // Проверяем, является ли владельцем пулла
                $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

                if ($pullInfo) {
                    $peerIds = explode(',', $pullInfo['peer_ids']);

                    if (in_array($peer_id, $peerIds)) {
                        // Удаляем текущую беседу из списка peer_ids
                        $peerIds = array_diff($peerIds, [$peer_id]);

                        // Обновляем запись о pull
                        $pullInfo->peer_ids = implode(',', $peerIds);
                        R::store($pullInfo);

                       forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа успешно удалена из вашего pull.");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта беседа не находится в вашем pull.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет активного pull.");
                }
            } else {
               forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
            }
        } else {
           forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к данной команде!");
        }
    }
}

if ($cmd == 'gzov') {
    if (isset($commandAccessLevels['gzov'])) {
        $requiredAccessLevel = $commandAccessLevels['gzov'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Получаем текст сообщения из аргументов команды
        $messageText = trim(implode(' ', array_slice($args, 0)));

        // Проверяем, что текст сообщения не пустой и не превышает 200 слов
        if (!empty($messageText) && str_word_count($messageText) <= 200) {
            // Получаем информацию о текущей беседе
            $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

            if ($chatInfo) {
                // Получаем id владельца текущей беседы
                $ownerId = $chatInfo['owner_id'];

                // Проверяем, является ли владельцем пулла
                $pullInfo = R::findOne('pulls', 'user_id = ?', [$ownerId]);

                if ($pullInfo) {
                    $peerIds = explode(',', $pullInfo['peer_ids']);
                    $mentionString = "";

                    foreach ($peerIds as $peerId) {
                        // Проверяем, что peerId положительное
                        if ($peerId > 0) {
                            // Получаем список участников беседы
                            $conversationMembers = $vk->request('messages.getConversationMembers', [
                                'peer_id' => $peerId,
                                'fields' => 'id',
                            ]);

                            if (isset($conversationMembers['items']) && is_array($conversationMembers['items']) && count($conversationMembers['items']) > 0) {
                                // Формируем строку с упоминаниями всех положительных id участников беседы
                                $mentionString = "";
                                $first = true;

                                foreach ($conversationMembers['items'] as $member) {
                                    $userId = $member['member_id'];

                                    if ($userId > 0) {
                                        if (!$first) {
                                            $mentionString .= " ";
                                        }
                                        $mentionString .= "[id$userId|.]";
                                        $first = false;
                                    }
                                }

                                if (!empty($mentionString)) {
                                    // Формируем сообщение с текстом и упоминаниями
                                    $finalMessage = "Внимание, Вы были вызваны [id{$id}|Администратором] беседы!!!\n$mentionString\n$messageText";

                                    // Отправляем сообщение в беседу
                                    $vk->sendMessage($peerId, $finalMessage, null, ['disable_mentions' => false]);
                                }
                            }
                        }
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Ваша беседа не включена в общий пулл!");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
            }
        } else {
           forwardMessage($vk, $peer_id, $messageIdToReply, "Некорректный текст сообщения. Убедитесь, что он не пустой и не превышает 200 слов.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к данной команде");
    }
  }
}
if (in_array($cmd, ['gkick'])) {
  $chat_ids = array(9, 10, 11, 12);
    if(in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75){
        forwardMessage($vk, $peer_id, $messageIdToReply,"К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['gkick'])) {
        $requiredAccessLevel = $commandAccessLevels['gkick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Получаем информацию о текущей беседе
        $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

        if ($chatInfo) {
            // Получаем id владельца текущей беседы
            $ownerId = $chatInfo['owner_id'];

            // Проверяем, является ли владельцем пулла
            $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

            if ($pullInfo) {
                $peerIds = explode(',', $pullInfo['peer_ids']);

                // Получаем аргументы команды после /gkick
                $argsCount = count($args);

                if ($argsCount >= 1) {
                    $target = $args[0];

                    if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                        $trUser = (int)$matches[1];
                    } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                        $trUser = (int)$matches[1];
                    } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                        $username = $matches[1];
                        $userInfo = $vk->request('utils.resolveScreenName', [
                            'screen_name' => $username,
                        ]);
                        if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                            $trUser = $userInfo['object_id'];
                        }
                    }
                    }elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                    // Извлекаем from_id из первого пересланного сообщения
                    $targetUserObj = $data->object->fwd_messages[0];
                    if (isset($targetUserObj->from_id)) {
                        $trUser = (int)$targetUserObj->from_id;
                    }
                   }else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gkick [userid]!");
                    exit;
                } 
                    if ($trUser === $user['user_id']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете кикнуть себя из беседы.");
                    } else {
                        // Получаем информацию о пользователе, которого пытаемся кикнуть
                        $trUserAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);

                        // Проверяем, что администратор с более низким уровнем не может кикнуть пользователя с более высоким уровнем
                        if ($adminCheck['lvl'] <= $trUserAdminInfo['lvl']) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете кикнуть пользователя с более высоким уровнем администратора.");
                        } else {
                            foreach ($peerIds as $peerId) {
                                $chatId = $peerId - 2000000000; // Получаем chat_id

                                // Выполняем исключение пользователя из беседы
                                $result = $vk->request('messages.removeChatUser', [
                                    'chat_id' => $chatId, // Используем chat_id
                                    'member_id' => $trUser,
                                ]);
                            }

                            if (!empty($result)) {
                                // Оповещение о кике
                                forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|Администратор] исключил [id{$trUser}|пользователя] из всех чатов.");

                                // Удаление пользователя из таблиц nickname (по chat_id)
                                foreach ($peerIds as $peerId) {
                                    $chatId = $peerId - 2000000000; // Получаем chat_id
                                    $userNicknameRecord = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                                    if ($userNicknameRecord) {
                                        R::trash($userNicknameRecord);
                                    }
                                }

                                // Удаление пользователя из таблиц usersadmin (по chat_id)
                                foreach ($peerIds as $peerId) {
                                    $chatId = $peerId - 2000000000; // Получаем chat_id
                                    $userAdminRecord = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                                    if ($userAdminRecord) {
                                        R::trash($userAdminRecord);
                                    }
                                }
                            } else {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось исключить пользователя из одной или нескольких бесед. Пожалуйста, проверьте правильность ID пользователя и вашей административной роли.");
                            }
                        }
                    }
                /*} else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gkick [userid]!");
                }*/
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Ваша беседа не включена в общий пулл!");
            }
        } else {
           forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Ваш уровень доступа недостаточен для использования данной команды!");
    }
  }
}

// TEST

if (in_array($cmd, ['gsnick', 'гсник'])) {
    
    if (isset($commandAccessLevels['gsnick']) && $adminCheck['lvl'] >= $commandAccessLevels['gsnick']) {
        if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
            $trUser = $data->object->fwd_messages[0]->from_id;
        } else {
            $target = trim($args[0]);
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                $trUser = (int)$matches[1];
            }
            elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $trUser = (int)$matches[1];
            }
            elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                $username = $matches[1];
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);
                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $trUser = $userInfo['object_id'];
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось найти пользователя по указанной ссылке.");
                    return;
                }
            }
            elseif (preg_match('/https:\/\/vk\.com\/profile(\d+)/', $target, $matches)) {
                $trUser = (int)$matches[1];
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте /gsnick [упоминание пользователя] [NickName (До 100 символов)].");
                return;
            }
        }

        $newNickname = trim(implode(' ', array_slice($args, 1)));
        $newNickname = mb_substr($newNickname, 0, 100);

        $userInfo = $vk->request("users.get", ["user_ids" => $trUser]);
        $targetFirstName = $userInfo[0]['first_name'];
        $targetLastName = $userInfo[0]['last_name'];
        
        $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        if ($chatInfo) {
            $ownerId = $chatInfo['owner_id'];
            $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);
            
            if (!$pullInfo || !in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Данная беседа не включена в общий пулл.");
                return;
            }

            $peerIds = explode(',', $pullInfo['peer_ids']);

            foreach ($peerIds as $peerId) {
                $chatId = $peerId - 2000000000;

                $existingNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                
                if ($existingNickname) {
                    $existingNickname['nickname'] = $newNickname;
                    $existingNickname['first_name'] = $targetFirstName;
                    $existingNickname['last_name'] = $targetLastName;
                    R::store($existingNickname);
                } else {
                    $newNicknameRow = R::dispense('nickname');
                    $newNicknameRow->user_id = $trUser;
                    $newNicknameRow->nickname = $newNickname;
                    $newNicknameRow->first_name = $targetFirstName;
                    $newNicknameRow->last_name = $targetLastName;
                    $newNicknameRow->beseda_id = $chatId;
                    R::store($newNicknameRow);
                }
            }

            $bstatus = R::findOne('users', 'user_id = ?', [$id]);
            $status = $bstatus ? getRankUser($bstatus->bstatus) : 'Пользователь';
            $message = "$status @id{$id} ({$user['nick']}) установил никнейм $newNickname пользователю @id{$id} ({$user['nick']}) во всех беседах пулла.";
            forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
            return;
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка: Не удалось найти информацию о пулле.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У Вас нет доступа к данной команде!");
    }
}

// CLOSE 

if (in_array($cmd, ['gban'])) {
  $chat_ids = array(9, 10, 11, 12);
    if(in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75){
        forwardMessage($vk, $peer_id, $messageIdToReply,"К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['gban']) && $adminCheck['lvl'] >= $commandAccessLevels['gban']) {
        if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
            // Извлекаем from_id из первого пересланного сообщения
            $banUser = $data->object->fwd_messages[0]->from_id;
            if ($banUser === false) {
                $adminName = isset($user['nick']) ? $user['nick'] : "{$user['first_name']} {$user['last_name']}";
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ($adminName), невозможно определить id пользователя для блокировки.");
                return;
            }
            $adminInfo = $vk->request('users.get', ['user_ids' => $id, 'fields' => 'first_name,last_name']);
            $banTime = time();
            $banDuration = parseBanDuration1($args);

            if ($banDuration === false) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Некорректно указан срок блокировки.");
                return;
            }

            $reason = implode(' ', array_slice($args, $banDuration === null ? 0 : 1));

            $userAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$banUser, $chat_id]);

            if ($userAdminInfo && $userAdminInfo['lvl'] >= $adminCheck['lvl']) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете заблокировать администратора с более высоким уровнем доступа.");
                return;
            }

            $existingBan = R::findOne('banusers', 'user_id = ? AND beseda_id = ?', [$banUser, $chat_id]);

            if ($existingBan) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь уже заблокирован в данной беседе.");
                return;
            }

            $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

            if ($chatInfo) {
                $ownerId = $chatInfo['owner_id'];
                $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

                if (!$pullInfo || !in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Данная беседа не включена в общий пулл.");
                    return;
                }

                $peerIds = explode(',', $pullInfo['peer_ids']);

                foreach ($peerIds as $peerId) {
                    $chatId = $peerId - 2000000000;

                    // Check if the target user is present in the chat
                    $userInChat = $vk->request('messages.getConversationMembers', [
                        'peer_id' => $peerId,
                        'fields' => 'id',
                        'group_id' => GROUP_ID, // Replace with your group ID
                    ]);

                    $userIdsInChat = array_column($userInChat['items'], 'member_id');
                    $userNicknameRecord = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$banUser, $chat_id]);
                    $adminNick = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);

                    if (!in_array($banUser, $userIdsInChat)) {
                        $adminInfo = $vk->request('users.get', ['user_ids' => $id, 'fields' => 'first_name,last_name']);
                        $message = "[id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}] заблокировал " . getUserMention($vk, $banUser, $userNicknameRecord) . " во всех чатах пулла до " . date('Y-m-d H:i:s', $banDuration ?? (99999 * 86400)) . ".\nПричина: $reason";
                        createBanEntry($banUser, $banTime, $banDuration, $reason, $id, $chatId);
                            // Логируем блокировку
                        $punishmentType = 'Блокировка';
                        $adminNickname = $adminNames['nick']; // Измените на соответствующее поле, если оно есть в вашей базе данных
                        $reasonLog = $reason;
                        $datePunishment = date('Y-m-d H:i:s');
                        $bannerid = $id;

                        // Записываем информацию о наказании в таблицу logs
                        R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                            [$banUser, $chatId, $punishmentType, $bannerid, $adminNickname, $reasonLog, $datePunishment]);
                        $vk->sendMessage($peerId, $message);
                    } else {
                        $vk->request('messages.removeChatUser', [
                            'chat_id' => $chatId,
                            'user_id' => $banUser,
                        ]);
                        $adminInfo = $vk->request('users.get', ['user_ids' => $id, 'fields' => 'first_name,last_name']);
                        $message = "[id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}] заблокировал " . getUserMention($vk, $banUser, $userNicknameRecord) . " во всех чатах пулла до " . date('Y-m-d H:i:s', $banDuration ?? (99999 * 86400)) . ".\nПричина: $reason";
                        createBanEntry($banUser, $banTime, $banDuration, $reason, $id, $chatId);
                            // Логируем блокировку
                        $punishmentType = 'Блокировка';
                        $adminNickname = $adminNames['nick']; // Измените на соответствующее поле, если оно есть в вашей базе данных
                        $reasonLog = $reason;
                        $datePunishment = date('Y-m-d H:i:s');
                        $bannerid = $id;
                        // Записываем информацию о наказании в таблицу logs
                        R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                            [$banUser, $chatId, $punishmentType, $bannerid, $adminNickname, $reasonLog, $datePunishment]);
                        $vk->sendMessage($peerId, $message);
                    }
                }
            }
        } else {
        $argsCount = count($args);

        if ($argsCount >= 1) {
            $target = $args[0];
            $banUser = parseBanTarget($vk, $target);

            if ($banUser === false) {
                $adminName = isset($user['nick']) ? $user['nick'] : "{$user['first_name']} {$user['last_name']}";
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ($adminName), невозможно определить id пользователя для блокировки.");
                return;
            }

) VALUES (?, ?, ?, ?, ?, ?, ?)',
                            [$banUser, $chatId, $punishmentType, $bannerid, $adminNickname, $reasonLog, $datePunishment]);
                        $vk->sendMessage($peerId, $message);
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gban [userid] [reason]!");
        }
    } 
  } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к данной команде");
}
}
if (in_array($cmd, ['gunban'])) {
    if (isset($commandAccessLevels['gunban'])) {
        $requiredAccessLevel = $commandAccessLevels['gunban'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $unbanUser = 0;

            $argsCount = count($args);
            if ($argsCount >= 1) {
                $target = $args[0];
                if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                    $unbanUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                    $unbanUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $unbanUser = $userInfo['object_id'];
                    }
                }
            }

            $unbanUser = is_numeric($unbanUser) ? (int)$unbanUser : 0;

            if (empty($unbanUser)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gunban [userid]");
            } else {
                $existingBan = R::findOne('banusers', 'user_id = ?', [$unbanUser]);
                if ($existingBan) {
                    $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                    if ($chatInfo) {
                        $ownerId = $chatInfo['owner_id'];
                        $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);
                        if ($pullInfo && in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                            $peerIds = explode(',', $pullInfo['peer_ids']);
                            foreach ($peerIds as $peerId) {
                                $chatId = $peerId - 2000000000;

                                // Удаляем пользователя из таблицы `banusers` конкретной беседы
                                R::exec("DELETE FROM banusers WHERE user_id = ? AND beseda_id = ?", [$unbanUser, $chatId]);

                                $vk->sendMessage($peerId, "[id{$id}|Администратор] разблокировал [id{$unbanUser}|пользователя] во всех чатах пулла!");
                            }
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Эта беседа не включена в общий пулл");
                            exit;
                        }
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не заблокирован.");
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к этой команде!");
        }
    }
}
if (in_array($cmd, ['grole'])) {
    if (isset($commandAccessLevels['grole'])) {
        $requiredAccessLevel = $commandAccessLevels['grole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $trUser = $data->object->fwd_messages[0]->from_id;
                if (empty($trUser)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /grole [userid] [role]!");
                } else {
                    if (isset($args[0])) {
                        $lvladmin = intval($args[0]);
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /grole [userid] [role]!");
                        exit;
                    }
        
                    // Проверяем, является ли отправитель владельцем пулла
                    $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        
                    if ($chatInfo) {
                        // Получаем id владельца текущей беседы
                        $ownerId = $chatInfo['owner_id'];
        
                        // Проверяем, является ли владельцем пулла
                        $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);
        
                        if ($pullInfo) {
                            $peerIds = explode(',', $pullInfo['peer_ids']);
        
                            $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                            $trUserInfo = R::findOne('users', 'user_id = ?', [$trUser]);
        
                            $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                            if($adminCheck['lvl'] <= $lvladmin ||$adminCheck['lvl'] <= $userAdminInfoTr['lvl'] || $lvladmin > 99) {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы пытаетесь воздействовать на вышестоящего пользователя, или выдать недопустимый уровень");
                            } else {
                                if ($lvladmin === 0) {
                                    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                                    if ($userAdminInfoTr) {
                                        R::trash($userAdminInfoTr);
                                    }
                                } else {
                                    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                                    if ($userAdminInfoTr) {
                                        $userAdminInfoTr['lvl'] = $lvladmin;
                                        $userAdminInfoTr['user_name'] = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                        $userAdminInfoTr['admin_name'] = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                        R::store($userAdminInfoTr);
                                    } else {
                                        $newUserAdmin = R::dispense('usersadmin');
                                        $newUserAdmin->user_id = $trUser;
                                        $newUserAdmin->beseda_id = $chat_id;
                                        $newUserAdmin->lvl = $lvladmin;
                                        $newUserAdmin->user_name = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                        $newUserAdmin->admin_name = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                        R::store($newUserAdmin);
                                    }
                                }
        
                                $adminLevelName = $adminLevelNames[$lvladmin] ?? 'Неизвестный уровень';
                                forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|Администратор] назначил [id{$trUser}|пользователя] администратором уровня '{$lvladmin}' во всех чатах пулла!");
                                $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) назначил вас администратором уровня '{$lvladmin}'!");
        
                                // Перебираем остальные беседы из пулла и назначаем админом с указанным уровнем
                                foreach ($peerIds as $peerId) {
                                    $chatId = $peerId - 2000000000; // Получаем chat_id
                                    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                                    if ($userAdminInfoTr) {
                                        $userAdminInfoTr['lvl'] = $lvladmin;
                                        $userAdminInfoTr['user_name'] = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                        $userAdminInfoTr['admin_name'] = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                        R::store($userAdminInfoTr);
                                    } else {
                                        $newUserAdmin = R::dispense('usersadmin');
                                        $newUserAdmin->user_id = $trUser;
                                        $newUserAdmin->beseda_id = $chatId;
                                        $newUserAdmin->lvl = $lvladmin;
                                        $newUserAdmin->user_name = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                        $newUserAdmin->admin_name = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                        R::store($newUserAdmin);
                                    }
                                }
                            }
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Ваша беседа не включена в общий пулл");
                        }
                    } else {
                       forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
                    }
                }
            } else { $trUser = 0;

        $argsCount = count($args);
        if ($argsCount >= 1) {
            $target = $args[0];
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                $trUser = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $trUser = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                $username = $matches[1];
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);
                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $trUser = $userInfo['object_id'];
                }
            }
        }

        $trUser = is_numeric($trUser) ? (int)$trUser : 0;

        if (empty($trUser)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /grole [userid] [role]!");
        } else {
            if (isset($args[1])) {
                $lvladmin = intval($args[1]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /grole [userid] [role]!");
                exit;
            }

            // Проверяем, является ли отправитель владельцем пулла
            $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

            if ($chatInfo) {
                // Получаем id владельца текущей беседы
                $ownerId = $chatInfo['owner_id'];

                // Проверяем, является ли владельцем пулла
                $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

                if ($pullInfo) {
                    $peerIds = explode(',', $pullInfo['peer_ids']);

                    $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                    $trUserInfo = R::findOne('users', 'user_id = ?', [$trUser]);

                    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                    if($adminCheck['lvl'] <= $lvladmin ||$adminCheck['lvl'] <= $userAdminInfoTr['lvl'] || $lvladmin > 99) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы пытаетесь воздействовать на вышестоящего пользователя, или выдать недопустимый уровень");
                    } else {
                        if ($lvladmin === 0) {
                            $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                            if ($userAdminInfoTr) {
                                R::trash($userAdminInfoTr);
                            }
                        } else {
                            $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                            if ($userAdminInfoTr) {
                                $userAdminInfoTr['lvl'] = $lvladmin;
                                $userAdminInfoTr['user_name'] = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                $userAdminInfoTr['admin_name'] = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                R::store($userAdminInfoTr);
                            } else {
                                $newUserAdmin = R::dispense('usersadmin');
                                $newUserAdmin->user_id = $trUser;
                                $newUserAdmin->beseda_id = $chat_id;
                                $newUserAdmin->lvl = $lvladmin;
                                $newUserAdmin->user_name = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                $newUserAdmin->admin_name = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                R::store($newUserAdmin);
                            }
                        }

                        $adminLevelName = $adminLevelNames[$lvladmin] ?? 'Неизвестный уровень';
                        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|Администратор] назначил [id{$trUser}|пользователя] администратором уровня '{$lvladmin}' во всех чатах пулла!");
                        $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) назначил вас администратором уровня '{$lvladmin}'!");

                        // Перебираем остальные беседы из пулла и назначаем админом с указанным уровнем
                        foreach ($peerIds as $peerId) {
                            $chatId = $peerId - 2000000000; // Получаем chat_id
                            $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);
                            if ($userAdminInfoTr) {
                                $userAdminInfoTr['lvl'] = $lvladmin;
                                $userAdminInfoTr['user_name'] = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                $userAdminInfoTr['admin_name'] = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                R::store($userAdminInfoTr);
                            } else {
                                $newUserAdmin = R::dispense('usersadmin');
                                $newUserAdmin->user_id = $trUser;
                                $newUserAdmin->beseda_id = $chatId;
                                $newUserAdmin->lvl = $lvladmin;
                                $newUserAdmin->user_name = $trUserInfo['user_name'] . ' ' . $trUserInfo['surname'];
                                $newUserAdmin->admin_name = $adminInfo['admin_name'] . ' ' . $adminInfo['surname'];
                                R::store($newUserAdmin);
                            }
                        }
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Ваша беседа не включена в общий пулл");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о текущей беседе.");
            }
        }
    } 
  } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Ваш уровень допуска недостаточен для выполнения команды");
 } 
}
}
//======================================================================================================================================//
// RESYNC//
if (in_array($cmd, ['resync'])) {
    if ($adminCheck && $adminCheck['lvl'] >= 50) {
        updateChatSettings($vk, $peer_id, $chat_id);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для пользователей с статусом Администратор(50)!");
    }
}


if (in_array($cmd, ['gresync'])) {
    
    if ($adminCheck && $adminCheck['lvl'] >= 50) {
        if (in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
            return;
        }

        $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        if ($chatInfo) {
            $ownerId = $chatInfo['owner_id'];
            $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

            if (!$pullInfo || !in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Данная беседа не включена в общий пулл.");
                return;
            }

            $peerIds = explode(',', $pullInfo['peer_ids']);

            foreach ($peerIds as $peerId) {
                $chatId = $peerId - 2000000000;

                updateChatSettings($vk, $peer_id, $chatId);
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки обновлены во всех беседах пула.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка: Не удалось найти информацию о пулле.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для пользователей с статусом Администратор(50)!");
    }
}

//===================//
// ----------------------------------------------СИСТЕМА НИКНЕЙМОВ-------------------------------------------------
if (in_array($cmd, ['setnick', 'snick', 'newnick', 'новыйник'])) {
    if (isset($commandAccessLevels['snick'])) {
        $requiredAccessLevel = $commandAccessLevels['snick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $trUser = $data->object->fwd_messages[0]->from_id;
                $newNickname = trim(implode(' ', array_slice($args, 0)));
                $newNickname = mb_substr($newNickname, 0, 100); 
                $chatId = $chat_id;

                $userInfo = $vk->request("users.get", ["user_ids" => $trUser]);
                $targetFirstName = $userInfo[0]['first_name'];
                $targetLastName = $userInfo[0]['last_name'];

                $existingNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);

                if ($existingNickname) {
                    $existingNickname['nickname'] = $newNickname;
                    $existingNickname['first_name'] = $targetFirstName;
                    $existingNickname['last_name'] = $targetLastName;
                    R::store($existingNickname);

                    $status = "Неизвестный";
                    $bstatus = R::findOne('users', 'user_id = ?', [$id]);
                    if ($bstatus) {
                        $bstat = $bstatus ? $bstatus->bstatus : 0;
                        if ($bstat > 0) {
                            $status = getRankUser($bstat);
                        } elseif ($bstat == 0) {
                            $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                            if ($adminRole) {
                                $status = $adminRole->roles;
                            } else {
                                $status = "Пользователь";
                            }
                        }
                    }

                    $message = "$status @id{$id} ({$user['nick']}) установил никнейм $newNickname пользователю @id{$trUser}";
                    forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);

                    // Логирование использования команды
                    $logEntry = R::dispense('userlog');
                    $logEntry->user_id = $id;
                    $logEntry->cmd = 'snick';
                    $logEntry->text = implode(' ', $args);
                    $logEntry->date = date('Y-m-d H:i:s');
                    $logEntry->beseda_id = $chatId;
                    R::store($logEntry);
                } else {
                    $newNicknameRow = R::dispense('nickname');
                    $newNicknameRow->user_id = $trUser;
                    $newNicknameRow->nickname = $newNickname;
                    $newNicknameRow->first_name = $targetFirstName;
                    $newNicknameRow->last_name = $targetLastName;
                    $newNicknameRow->beseda_id = $chatId;

                    R::store($newNicknameRow);

                    $bstatus = R::findOne('users', 'user_id = ?', [$id]);
                    if ($bstatus) {
                        $bstat = $bstatus ? $bstatus->bstatus : 0;
                        if ($bstat > 0) {
                            $status = getRankUser($bstat);
                        } elseif ($bstat == 0) {
                            $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                            if ($adminRole) {
                                $status = $adminRole->roles;
                            } else {
                                $status = "Пользователь";
                            }
                        }
                    }

                    $message = "$status @id{$id} ({$user['nick']}) установил никнейм $newNickname пользователю @id{$trUser}";
                    forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);

                    // Логирование использования команды
                    $logEntry = R::dispense('userlog');
                    $logEntry->user_id = $id;
                    $logEntry->cmd = 'snick';
                    $logEntry->text = implode(' ', $args);
                    $logEntry->date = date('Y-m-d H:i:s');
                    $logEntry->beseda_id = $chatId;
                    R::store($logEntry);
                }
            } else {
                $newNickname = trim(implode(' ', array_slice($args, 1)));
                $newNickname = mb_substr($newNickname, 0, 100);

                if (empty($newNickname)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте /snick [id пользователя] [никнейм (100)]");
                } else {
                    $trUser = null;

                    if (count($args) >= 1) {
                        $target = $args[0];

                        if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                            $trUser = (int)$matches[1];
                        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                            $trUser = (int)$matches[1];
                        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                            $username = $matches[1];
                            $userInfo = $vk->request('utils.resolveScreenName', [
                                'screen_name' => $username,
                            ]);
                            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                                $trUser = $userInfo['object_id'];
                            }
                        }
                    }

                    if (empty($trUser)) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте /snick [id пользователя] [никнейм (100)]");
                    } else {
                        $chatId = $chat_id;

                        $userInfo = $vk->request("users.get", ["user_ids" => $trUser]);
                        $targetFirstName = $userInfo[0]['first_name'];
                        $targetLastName = $userInfo[0]['last_name'];

                        $existingNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);

                        if ($existingNickname) {
                            $existingNickname['nickname'] = $newNickname;
                            $existingNickname['first_name'] = $targetFirstName;
                            $existingNickname['last_name'] = $targetLastName;
                            R::store($existingNickname);

                            $bstatus = R::findOne('users', 'user_id = ?', [$id]);
                            if ($bstatus) {
                                $bstat = $bstatus ? $bstatus->bstatus : 0;
                                if ($bstat > 0) {
                                    $status = getRankUser($bstat);
                                } elseif ($bstat == 0) {
                                    $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                                    if ($adminRole) {
                                        $status = $adminRole->roles;
                                    } else {
                                        $status = "Пользователь";
                                    }
                                }
                            }

                            $message = "$status @id{$id} ({$user['nick']}) установил никнейм $newNickname пользователю @id{$trUser}";
                            forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);

                            // Логирование использования команды
                            $logEntry = R::dispense('userlog');
                            $logEntry->user_id = $id;
                            $logEntry->cmd = 'snick';
                            $logEntry->text = implode(' ', $args);
                            $logEntry->date = date('Y-m-d H:i:s');
                            $logEntry->beseda_id = $chatId;
                            R::store($logEntry);
                        } else {
                            $newNicknameRow = R::dispense('nickname');
                            $newNicknameRow->user_id = $trUser;
                            $newNicknameRow->nickname = $newNickname;
                            $newNicknameRow->first_name = $targetFirstName;
                            $newNicknameRow->last_name = $targetLastName;
                            $newNicknameRow->beseda_id = $chatId;
                            R::store($newNicknameRow);

                            $bstatus = R::findOne('users', 'user_id = ?', [$id]);
                            if ($bstatus) {
                                $bstat = $bstatus ? $bstatus->bstatus : 0;
                                if ($bstat > 0) {
                                    $status = getRankUser($bstat);
                                } elseif ($bstat == 0) {
                                    $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                                    if ($adminRole) {
                                        $status = $adminRole->roles;
                                    } else {
                                        $status = "Пользователь";
                                    }
                                }
                            }

                            $message = "$status @id{$id} ({$user['nick']}) установил никнейм $newNickname пользователю @id{$trUser}";
                            forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);

                            // Логирование использования команды
                            $logEntry = R::dispense('userlog');
                            $logEntry->user_id = $id;
                            $logEntry->cmd = 'snick';
                            $logEntry->text = implode(' ', $args);
                            $logEntry->date = date('Y-m-d H:i:s');
                            $logEntry->beseda_id = $chatId;
                            R::store($logEntry);
                        }
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У Вас нет доступа к данной команде!");
            exit;
        }
    }
}

if (in_array($cmd, ['nonames', 'nonicks', 'безников'])) {
    if (isset($commandAccessLevels['nonames'])) {
        $requiredAccessLevel = $commandAccessLevels['nonames'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $chatId = $chat_id; // Идентификатор текущей беседы

            // Получаем список участников беседы
            $conversationMembers = $vk->request('messages.getConversationMembers', [
                'peer_id' => $peer_id,
                'fields' => 'id',
            ]);

            if (isset($conversationMembers['items']) && is_array($conversationMembers['items']) && count($conversationMembers['items']) > 0) {
                // Получаем список всех пользователей из таблицы nickname конкретной беседы
                $nicknames = R::getAll("SELECT user_id FROM nickname WHERE beseda_id = {$chatId}");
                $nicknameUsers = array_column($nicknames, 'user_id');

                // Формируем список пользователей без никнеймов
                $usersWithoutNicknames = [];

                foreach ($conversationMembers['items'] as $member) {
                    $userId = $member['member_id'];

                    // Проверяем, что пользователь не имеет ID 223222595
                    if ($userId != -223222595 && !in_array($userId, $nicknameUsers)) {
                        $usersWithoutNicknames[] = $userId;
                    }
                }

                if (!empty($usersWithoutNicknames)) {
                    $message = "👤 Пользователи без никнеймов (Страница $page):\n\n";

                    // Устанавливаем количество пользователей на странице и смещение
                    $usersPerPage = 50; // Количество пользователей на странице
                    $page = (int)($args[0] ?? 1); // Получаем номер страницы из аргументов команды
                    if ($page < 1) {
                        $page = 1;
                    }
                    $offset = ($page - 1) * $usersPerPage;

                    // Получаем только пользователей для текущей страницы
                    $usersOnPage = array_slice($usersWithoutNicknames, $offset, $usersPerPage);

                    // Используем счетчик для нумерации пользователей на странице
                    $counter = $offset + 1;

                    foreach ($usersOnPage as $userId) {
                        // Получаем информацию о пользователе
                        $userInfo = $vk->request("users.get", ["user_ids" => $userId]);
                        $fullName = "{$userInfo[0]['first_name']} {$userInfo[0]['last_name']}";
                        $message .= "{$counter}. [id{$userId}|{$fullName}]\n\n";
                        $counter++;
                    }

                    forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Страница пользователей без ников пуста.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить список участников беседы.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для Вас!");
        }
    }
}
if (in_array($cmd, ['кикбезников'])) {
    if (isset($commandAccessLevels['кикбезников'])) {
        $requiredAccessLevel = $commandAccessLevels['кикбезников'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $chatId = $chat_id; // Идентификатор текущей беседы

            // Получаем список участников беседы
            $conversationMembers = $vk->request('messages.getConversationMembers', [
                'peer_id' => $peer_id,
                'fields' => 'id',
            ]);

            if (isset($conversationMembers['items']) && is_array($conversationMembers['items']) && count($conversationMembers['items']) > 0) {
                // Получаем список всех пользователей из таблицы nickname конкретной беседы
                $nicknames = R::getAll("SELECT user_id FROM nickname WHERE beseda_id = {$chatId}");
                $nicknameUsers = array_column($nicknames, 'user_id');

                // Формируем список пользователей без никнеймов, которых нужно кикнуть
                $usersWithoutNicknames = [];

                foreach ($conversationMembers['items'] as $member) {
                    $userId = $member['member_id'];

                    // Проверяем, что пользователь не имеет ID 223222595
                    $nonameAdm = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$userId, $chat_id]);
                    if ($userId != -223222595 && !in_array($userId, $nicknameUsers) && $nonameAdm['lvl'] < 1) {
                        $usersWithoutNicknames[] = $userId;
                    }
                }

                if (!empty($usersWithoutNicknames)) {
                    foreach ($usersWithoutNicknames as $userId) {
                        // Используем метод messages.removeChatUser для кика пользователя из беседы
                        $vk->request('messages.removeChatUser', [
                            'chat_id' => $chatId,
                            'user_id' => $userId,
                        ]);
                    }

                    $kickedCount = count($usersWithoutNicknames);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "🚷 Успешно кикнуты {$kickedCount} пользователей без никнеймов.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользовватели для исключения не найдены.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить список участников беседы.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступна для Вас!");
        }
    }
}

if (in_array($cmd, ['nlist', 'nicklist', 'ники'])) {
    if (isset($commandAccessLevels['nlist'])) {
        $requiredAccessLevel = $commandAccessLevels['nlist'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $chatId = $chat_id; // Идентификатор текущей беседы

            // Предполагается, что у вас есть соединение с базой данных $db и таблица nickname
            $nicknames = R::find('nickname', 'beseda_id = ?', [$chatId]);

            if (!empty($nicknames)) {
                // Определяем количество никнеймов на странице и номер страницы
                $nicknamesPerPage = 30; // Количество никнеймов на странице
                $page = (int)($args[0] ?? 1); // Получаем номер страницы из аргументов команды
                if ($page < 1) {
                    $page = 1;
                }
                $offset = ($page - 1) * $nicknamesPerPage;

                // Отфильтруем никнеймы, соответствующие текущей странице
                $nicknamesOnPage = array_slice($nicknames, $offset, $nicknamesPerPage);

                $message = "Пользователи с никнеймами (Страница $page):\n\n";

                $counter = $offset + 1; // Инициализируем счетчик

                foreach ($nicknamesOnPage as $nickname) {
                    $fullName = "{$nickname->first_name} {$nickname->last_name}";
                    // Проверяем, является ли владельцем премиум-беседы и добавляем звездочку при необходимости
                    $isPremiumOwner = isPremiumOwner($nickname->user_id); // Здесь реализуйте проверку
                    $starEmoji = $isPremiumOwner ? "💎" : ""; // Звездочка

                    $message .= "{$counter}. [id{$nickname->user_id}|{$fullName}] {$starEmoji} — {$nickname->nickname}\n";
                    $counter++; // Увеличиваем счетчик
                }

                // Добавляем инструкцию по переключению между страницами
                $message .= "\nЧтобы перейти на другую страницу, используйте команду /nlist [номер страницы]. Например, /nlist 2.";

                forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "В этой беседе пока нет установленных никнеймов.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для Вас!");
        }
    }
}
if (in_array($cmd, ['getbynick'])) {
    if (isset($commandAccessLevels['getbynick'])) {
        $requiredAccessLevel = $commandAccessLevels['getbynick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, есть ли аргумент (никнейм) после команды
        if (isset($args[0])) {
            $partialNickname = trim($args[0]); // Убираем лишние пробелы

            // Предполагается, что у вас есть соединение с базой данных $db и таблица nickname
            $nickInfo = R::find('nickname', 'beseda_id = ? AND nickname LIKE ?', [$chat_id, '%' . $partialNickname . '%']);

            if (!empty($nickInfo)) {
                $message = "Найденные пользователи по запросу '{$partialNickname}' в этой беседе:\n\n";

                $counter = 1; // Инициализируем счетчик

                foreach ($nickInfo as $nick) {
                    $userId = $nick->user_id;
                    $fullName = "{$nick->first_name} {$nick->last_name}";
                    $message .= "{$counter}. [id{$userId}|{$fullName}] — {$nick->nickname}\n\n";
                    $counter++; // Увеличиваем счетчик
                }

                forwardMessage($vk, $peer_id, $messageIdToReply, $message);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователи с частью ника '{$partialNickname}' не найдены в этой беседе.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите часть никнейма после команды /getbynick для поиска пользователей.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для Вас!");
    }
  }
}
if (in_array($cmd, ['getnick', 'gnick', 'ник'])) {
    if (isset($commandAccessLevels['getnick'])) {
        $requiredAccessLevel = $commandAccessLevels['getnick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Извлекаем ID пользователя из сообщения
            $argsCount = count($args);
            $targetUserId = null;

            // Проверяем, был ли пользователь упомянут в сообщении
            if ($argsCount >= 1) {
                $target = $args[0];
                if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                    $targetUserId = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                    $targetUserId = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches) || preg_match('/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $targetUserId = $userInfo['user_id'];
                    }
                }
            } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $targetUserId = $data->object->fwd_messages[0]->from_id;
            }

            // Проверяем наличие пересылаемого сообщения или указанного ID пользователя
            if (isset($targetUserId) && is_numeric($targetUserId) && $targetUserId > 0) {
                // Ищем никнейм пользователя в базе данных
                $nickInfo = R::findOne('nickname', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUserId]);

                if ($nickInfo) {
                    $fullName = "{$nickInfo->first_name} {$nickInfo->last_name}";
                    forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$targetUserId}|{$fullName}] - {$nickInfo->nickname}");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "У [id{$targetUserId}|пользователя] в этой беседе нет никнейма.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите участника беседы, ник которого хотите просмотреть");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для Вас!");
        }
    }
}
if (in_array($cmd, ['rnick', 'removenick', 'рник'])) {
    if (isset($commandAccessLevels['rnick'])) {
        $requiredAccessLevel = $commandAccessLevels['rnick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Извлекаем ID пользователя из сообщения, если есть ответ на его сообщение
            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                $trUser = $data->object->fwd_messages[0]->from_id;
            } else {
                // Проверяем, был ли пользователь упомянут в сообщении
                preg_match('/\[id(\d+)\|.*\]/', $args[0], $matches);
                if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                    $trUser = (int)$matches[1]; // Если пользователь упомянут, извлекаем его ID
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $args[0], $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $args[0], $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $trUser = $userInfo['object_id'];
                    }
                }
            }

            if (empty($trUser)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали пользователя, чей никнейм нужно удалить.");
            } else {
                // Получите информацию об администраторе из таблицы usersadmin
                $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);

                if ($userAdminInfoTr) {
                    $trUserAdminLevel = $userAdminInfoTr['lvl'];

                    // Проверяем, что ваш уровень администратора меньше или равен уровню администратора пользователя, чей ник вы пытаетесь удалить
                    if ($adminCheck['lvl'] < $trUserAdminLevel) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете удалить никнейм пользователя с более высоким уровнем администратора.");
                    } else {
                        // Удалите запись с никнеймом у указанного пользователя
                        $deletedNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);

                        if ($deletedNickname) {
                            R::trash($deletedNickname); // Удаляем запись
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Никнейм пользователя успешно удален.");
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя нет никнейма для удаления.");
                        }
                    }
                } else {
                    // Если информация об администраторе не найдена, просто удаляем никнейм без дополнительных проверок
                    $deletedNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);

                    if ($deletedNickname) {
                        R::trash($deletedNickname); // Удаляем запись
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Никнейм пользователя успешно удален.");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя нет никнейма для удаления.");
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вам недоступна данная команда");
            exit;
        }
    }
}

if (in_array($cmd, ['grnick'])) {
    if (isset($commandAccessLevels['grnick'])) {
        $requiredAccessLevel = $commandAccessLevels['grnick'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {

            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                $trUser = $data->object->fwd_messages[0]->from_id;
            } else {
                preg_match('/\[id(\d+)\|.*\]/', $args[0], $matches);
                if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $args[0], $matches)) {
                    $trUser = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $args[0], $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $trUser = $userInfo['object_id'];
                    }
                }
            }

            if (empty($trUser)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали пользователя, чей никнейм нужно удалить.");
            } else {
                $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);

                if ($chatInfo) {
                    $ownerId = $chatInfo['owner_id'];
                    $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);

                    if (!$pullInfo || !in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Данная беседа не включена в общий пулл.");
                        return;
                    }

                    $peerIds = explode(',', $pullInfo['peer_ids']);
                    
                    foreach ($peerIds as $peerId) {
                        $chatId = $peerId - 2000000000;

                        $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);

                        if ($userAdminInfoTr) {
                            $trUserAdminLevel = $userAdminInfoTr['lvl'];

                            if ($adminCheck['lvl'] < $trUserAdminLevel) {
                                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете удалить никнейм пользователя с более высоким уровнем администратора.");
                                continue;
                            }
                        }
                        $deletedNickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$trUser, $chatId]);

                        if ($deletedNickname) {
                            R::trash($deletedNickname);
                            $message = "NickName пользователя успешно удалён во всех чатах пулла.";
                        } else {
                            $message = "У пользователя нет никнейма для удаления в чате {$chatId}.";
                        }

                        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вам недоступна данная команда.");
            exit;
        }
    }
}

//---------------------------------------------------------------------------------------------------------------------------
// ------------------Админ-система===========================================
if (in_array($cmd, ['warn', 'варн', 'пред'])) {
    $chat_ids = array(9, 10, 11, 12);
    if (in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['warn'])) {
        $requiredAccessLevel = $commandAccessLevels['warn'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем информацию о пользователе, которому выдаем предупреждение
            $targetUser = null;
            $reason = null;

            // Извлекаем ID пользователя из пересланного сообщения, если оно есть
            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                $targetUser = $data->object->fwd_messages[0]->from_id;
                $reason = trim(implode(' ', $args)); // Получаем причину
            } else {
                // Проверяем, был ли пользователь упомянут в сообщении
                preg_match('/\[id(\d+)\|.*\]/', $args[0], $matches);
                if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                    $targetUser = (int)$matches[1]; // Если пользователь упомянут, извлекаем его ID
                    $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $args[0], $matches)) {
                    $targetUser = (int)$matches[1];
                    $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $args[0], $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $targetUser = $userInfo['object_id'];
                        $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                    }
                }
            }

            // Если не удалось определить целевого пользователя, отправляем сообщение об ошибке
            if (!$targetUser) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /warn [userid] [причина]!");
            } else {
                // Проверяем, состоит ли целевой пользователь в беседе
                $isMember = $vk->request('messages.getConversationMembers', [
                    'peer_id' => $peer_id,
                    'fields' => 'id',
                ]);

                $isMemberIds = array_column($isMember['items'], 'member_id');

                if (!in_array($targetUser, $isMemberIds)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "[id$targetUser|Пользователь] не состоит в этой беседе и не может быть предупрежден.");
                } else {
                    // Получаем информацию о целевом пользователе
                    $targetUserInfo = $vk->request('users.get', ['user_ids' => $targetUser]);

                    if (!$targetUserInfo) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о пользователе [id$targetUser].");
                    } else {
                        $targetUserAdminLevel = R::findOne('usersadmin', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);

                        // Проверяем, имеет ли отправитель выше или равный уровень админки, чем целевой пользователь
                        if ($targetUserAdminLevel && $adminCheck['lvl'] <= $targetUserAdminLevel['lvl']) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете выдавать предупреждения этому пользователю.");
                        } else {
                            // Проверяем, сколько у пользователя уже предупреждений
                            $warnCount = R::count('userwarns', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);

                            // Проверка, чтобы не выдать больше 3 предупреждений
                            if ($warnCount >= 2) {
                                // Удаляем все предупреждения пользователя из таблицы конкретной беседы
                                R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);

                                // Записываем выговор в базу данных
                                $vig = R::dispense('uservig');
                                $vig->beseda_id = $chat_id;
                                $vig->user_id = $targetUser;
                                $vig->admin_id = $id;
                                $vig->reason = $reason;
                                $vig->date_vig = date('Y-m-d H:i:s');
                                R::store($vig);

                                forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователю [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] сняты все предупреждения и выдан выговор. Причина: $reason");

                                // Логируем выданный выговор
                                $punishmentType = 'Выговор';
                                $adminNickname = $adminNames['nick'];
                                $reasonLog = $reason;
                                $datePunishment = date('Y-m-d H:i:s');

                                // Записываем информацию о наказании в таблицу logs
                                R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                                    [$targetUser, $chat_id, $punishmentType, $id, $adminNickname, $reasonLog, $datePunishment]);
                                
                                // Логирование команды warn
                                $logText = isset($args) ? trim(implode(' ', $args)) : '';
                                R::exec('INSERT INTO userlog (user_id, cmd, text, date, beseda_id) VALUES (?, ?, ?, ?, ?)',
                                    [$id, 'warn', $logText, date('Y-m-d H:i:s'), $chat_id]);
                                
                            } else {
                                if (empty($reason)) {
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите причину предупреждения.");
                                } else {
                                    // Записываем предупреждение в базу данных
                                    $warn = R::dispense('userwarns');
                                    $warn->beseda_id = $chat_id;
                                    $warn->user_id = $targetUser;
                                    $warn->admin_id = $id;
                                    $warn->reason = $reason;
                                    $warn->date_warn = date('Y-m-d H:i:s');
                                    R::store($warn);

                                    // Логируем выданное предупреждение
                                    $punishmentType = 'Предупреждение';
                                    $adminNickname = $adminNames['nick'];
                                    $reasonLog = $reason;
                                    $datePunishment = date('Y-m-d H:i:s');

                                    // Записываем информацию о наказании в таблицу logs
                                    R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                                        [$targetUser, $chat_id, $punishmentType, $id, $adminNickname, $reasonLog, $datePunishment]);

                                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователю [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] выдано предупреждение. Причина: $reason");

                                    // Логируем использование команды
                                    $logText = isset($args) ? trim(implode(' ', $args)) : '';
                                    R::exec('INSERT INTO userlog (user_id, cmd, text, date, beseda_id) VALUES (?, ?, ?, ?, ?)',
                                        [$id, 'warn', $logText, date('Y-m-d H:i:s'), $chat_id]);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна на Вашем уровне");
            exit;
        }
    }
}


// Команда /warnhistory
if ($cmd == 'warnhistory') {
    if (isset($commandAccessLevels['warnhistory'])) {
        $requiredAccessLevel = $commandAccessLevels['warnhistory'];
        if ($adminCheck['lvl'] < $requiredAccessLevel) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно для Вас!");
            return;
        }

        // Извлекаем ID пользователя из сообщения
        $argsCount = count($args);
        $targetUserId = null;
        $page = 1;

        // Проверяем, был ли пользователь упомянут в сообщении
        if ($argsCount >= 1) {
            $target = $args[0];
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                $username = $matches[1];
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);
                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $targetUserId = $userInfo['user_id'];
                }
            }

            // Проверяем, указана ли страница
            if ($argsCount >= 2) {
                $page = max(1, (int)$args[1]);
            }
        } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
            // Извлекаем from_id из первого пересланного сообщения
            $targetUserId = $data->object->fwd_messages[0]->from_id;
        }

        if ($targetUserId) {
            // Запрос к базе данных для получения списка предупреждений данного пользователя в текущей беседе
            $warnings = R::findAll('logs', 'beseda_id = ? AND user_id = ? AND punishment_type = "Предупреждение" ORDER BY date_punishment DESC LIMIT ?, ?', [$chat_id, $targetUserId, ($page - 1) * 10, 10]);

            if (empty($warnings)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "История предупреждений пуста.");
            } else {
                // Формируем сообщение со списком предупреждений
                $message = "История предупреждений [id$targetUserId|пользователя] (Страница $page):\n\n";

                foreach ($warnings as $index => $warning) {
                    $adminNickname = $warning->admin_nickname ?: 'Неизвестно';
                    $reason = $warning->reason ?: 'Не указана';
                    $date = $warning->date_punishment;
                    $idAdmin = $warning->admin_id;
                    $message .= "🔹 Дата: $date | Причина: $reason | Выдал: [id$idAdmin|$adminNickname]\n";
                }

                forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /warnhistory [userid] [page] или перешлите сообщение.");
        }
    }
}
if ($cmd == 'banhistory') {
    if (isset($commandAccessLevels['banhistory'])) {
        $requiredAccessLevel = $commandAccessLevels['banhistory'];
        if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно для Вас!");
        return;
    }

    // Извлекаем ID пользователя из сообщения
    $argsCount = count($args);
    $targetUserId = null;

    // Проверяем, был ли пользователь упомянут в сообщении
    if ($argsCount >= 1) {
        $target = $args[0];
        if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
            $targetUserId = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
            $targetUserId = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $targetUserId = $userInfo['user_id'];
            }
        }
    } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
        // Извлекаем from_id из первого пересланного сообщения
        $targetUserId = $data->object->fwd_messages[0]->from_id;
    }

    if ($targetUserId) {
        // Запрос к базе данных для получения списка предупреждений данного пользователя в текущей беседе
        $banings = R::findAll('logs', 'beseda_id = ? AND user_id = ? AND punishment_type = "Блокировка"', [$chat_id, $targetUserId]);

        if (empty($banings)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "История блокировок пуста.");
        } else {
            // Формируем сообщение со списком предупреждений
            $message = "История блокировок [id$targetUserId|пользователя]:\n\n";

            foreach ($banings as $index => $baning) {
                $adminNickname = $baning->admin_nickname ?: 'Неизвестно';
                $reason = $baning->reason ?: 'Не указана';
                $date = $baning->date_punishment;
                $idAdmin = $baning->admin_id;
                $message .= "🔻 Дата: $date | Причина: $reason | Выдал: [id$idAdmin|$adminNickname]\n";
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /banhistory [userid] или перешлите сообщение.");
    }
}
}
// Команда /unwarn
if (in_array($cmd, ['unwarn', 'разварн'])) {
    $chat_ids = array(9, 10, 11, 12);
    if (in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['unwarn'])) {
        $requiredAccessLevel = $commandAccessLevels['unwarn'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем информацию о пользователе, которому снимаем предупреждение
            $targetUser = null;
            $warnLevel = 1; // По умолчанию снимаем старое предупреждение

            // Проверяем, есть ли в аргументах ссылка или упоминание пользователя
            foreach ($args as $arg) {
                // Проверяем, является ли аргумент ссылкой на профиль пользователя
                if (preg_match('/\[id(\d+)\|.*\]/', $arg, $matches)) {
                    if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                        $targetUser = $matches[1];
                        continue;
                    }
                }

                // Проверяем, является ли аргумент ссылкой на профиль пользователя в формате https://vk.com/id...
                if (preg_match('/https:\/\/vk\.com\/id(\d+)/', $arg, $matches)) {
                    if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                        $targetUser = $matches[1];
                        continue;
                    }
                }

                // Проверяем, является ли аргумент уровнем предупреждения
                if (in_array($arg, ['1', '2'])) {
                    $warnLevel = $arg;
                }
            }

            // Проверяем, были ли пересланы сообщения
            if (!$targetUser && isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $targetUser = $data->object->fwd_messages[0]->from_id;
            }

            // Если не удалось определить целевого пользователя, отправляем сообщение об ошибке
            if (!$targetUser) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите пользователя, у которого вы хотите снять предупреждение.\n Например, `/unwarn [id12345|username]` или `/unwarn [id12345|username] 2`.");
            } else {
                // Получаем информацию о целевом пользователе
                $targetUserInfo = $vk->request('users.get', ['user_ids' => $targetUser]);

                if (!$targetUserInfo) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о пользователе [id$targetUser].");
                } else {
                    // Получаем информацию о предупреждении, которое собираемся снять
                    $targetUserAdminLevel = R::findOne('usersadmin', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);
                    // Проверяем, имеет ли отправитель выше или равный уровень админки, чем целевой пользователь
                    if ($targetUserAdminLevel && $adminCheck['lvl'] <= $targetUserAdminLevel['lvl']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете снять предупреждение у этого пользователя!");
                        return;
                    }
                    $warnInfo = R::findOne('userwarns', 'beseda_id = ? AND user_id = ? ORDER BY date_warn ' . ($warnLevel == '1' ? 'ASC' : 'DESC'), [$chat_id, $targetUser]);

                    if($logInfo && $logInfo['admin_id'] == 678695202) {
                        if ($id == 678695202 || $id == 50776517) {
                         R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ? AND date_warn = ? LIMIT 1', [$chat_id, $targetUser, $warnInfo['date_warn']]);
                         
                         // Логирование использования команды
                         $logEntry = R::dispense('userlog');
                         $logEntry->user_id = $id;
                         $logEntry->cmd = 'unwarn';
                         $logEntry->text = implode(' ', $args);
                         $logEntry->date = date('Y-m-d H:i:s');
                         $logEntry->beseda_id = $chat_id;
                         R::store($logEntry);
                         
                         forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] снят варн.");
                         return;
                         } else {
                              forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете снять варн, выданный спонсором Blue.");
                              return;
                              }
                          }

                    // Проверяем, является ли отправитель тем же админом, который выдал предупреждение
                    if ($warnInfo && $warnInfo['admin_id'] == 678695202 || $warnInfo && $warnInfo['admin_id'] == 678695202 || $warnInfo && $warnInfo['admin_id'] == 678695202 || $warnInfo && $warnInfo['admin_id'] == 50776517 ) {
                            if ($id == 678695202 || $id == 50776517) {
                            // Удаляем одно предупреждение из базы данных
                            R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ? AND date_warn = ? LIMIT 1', [$chat_id, $targetUser, $warnInfo['date_warn']]);
                            
                            // Логирование использования команды
                            $logEntry = R::dispense('userlog');
                            $logEntry->user_id = $id;
                            $logEntry->cmd = 'unwarn';
                            $logEntry->text = implode(' ', $args);
                            $logEntry->date = date('Y-m-d H:i:s');
                            $logEntry->beseda_id = $chat_id;
                            R::store($logEntry);

                            forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] снято предупреждение.");
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете снять предупреждение, выданное администрацией бота Blue.");
                        }
                    } else {
                        // Удаляем одно предупреждение из базы данных
                        R::exec('DELETE FROM userwarns WHERE beseda_id = ? AND user_id = ? AND date_warn = ? LIMIT 1', [$chat_id, $targetUser, $warnInfo['date_warn']]);
                        
                        // Логирование использования команды
                        $logEntry = R::dispense('userlog');
                        $logEntry->user_id = $id;
                        $logEntry->cmd = 'unwarn';
                        $logEntry->text = implode(' ', $args);
                        $logEntry->date = date('Y-m-d H:i:s');
                        $logEntry->beseda_id = $chat_id;
                        R::store($logEntry);

                        forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] снято предупреждение.");
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно для Вас!");
        }
    }
}

if (in_array($cmd, ['getwarn', 'gwarn', 'варны'])) {
    if (isset($commandAccessLevels['getwarn'])) {
        $requiredAccessLevel = $commandAccessLevels['getwarn'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем информацию о пользователе, по которому хотим узнать предупреждения
            $targetUser = null;

            // Проверяем, есть ли в аргументах ссылка или упоминание пользователя
            foreach ($args as $arg) {
                // Проверяем, является ли аргумент ссылкой на профиль пользователя
                if (preg_match('/\[id(\d+)\|.*\]/', $arg, $matches)) {
                    if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                        $targetUser = $matches[1];
                        break;
                    }
                }

                // Проверяем, является ли аргумент ссылкой на профиль пользователя в формате https://vk.com/id...
                if (preg_match('/https:\/\/vk\.com\/id(\d+)/', $arg, $matches)) {
                    if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                        $targetUser = $matches[1];
                        break;
                    }
                }
            }

            // Проверяем, были ли пересланы сообщения
            if (!$targetUser && isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                // Извлекаем from_id из первого пересланного сообщения
                $targetUser = $data->object->fwd_messages[0]->from_id;
            }

            // Если не удалось определить целевого пользователя, отправляем сообщение об ошибке
            if (!$targetUser) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /getwarn [userid] или перешлите сообщение!");
            } else {
                // Получаем информацию о целевом пользователе
                $targetUserInfo = $vk->request('users.get', ['user_ids' => $targetUser]);

                if (!$targetUserInfo) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о пользователе [id$targetUser].");
                } else {
                    $targetUserAdminLevel = R::findOne('usersadmin', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);

                    // Проверяем, имеет ли отправитель выше или равный уровень админки, чем целевой пользователь
                    if ($targetUserAdminLevel && $adminCheck['lvl'] <= $targetUserAdminLevel['lvl']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете просматривать предупреждения этого пользователя.");
                    } else {
                        // Получаем предупреждения пользователя
                        $warns = R::findAll('userwarns', 'beseda_id = ? AND user_id = ?', [$chat_id, $targetUser]);

                        if ($warns) {
                            // Формируем сообщение с информацией о предупреждениях
                            $message = "🔴Действующие предупреждения [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}]:\n\n";

                            $counter = 1; // Счетчик для номерации предупреждений

                            foreach ($warns as $warn) {
                                $adminInfo = $vk->request('users.get', ['user_ids' => $warn->admin_id]);
                                $adminName = $adminInfo[0]['first_name'] . ' ' . $adminInfo[0]['last_name'];

                                $message .= "🔸 Предупреждение №{$counter}:\n";
                                $message .= "  Причина: " . $warn->reason . "\n";
                                $message .= "  Выдал: [id{$warn->admin_id}|$adminName]\n";
                                $message .= "  Дата: " . $warn->date_warn . "\n\n";

                                $counter++; // Увеличиваем счетчик
                            }

                           forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "У пользователя [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] нет предупреждений.");
                        }
                    }
                }
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для вас.");
        }
    }
}
if (in_array($cmd, ['warnlist'])) {
    if (isset($commandAccessLevels['warnlist'])) {
        $requiredAccessLevel = $commandAccessLevels['warnlist'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Устанавливаем количество пользователей с активными предупреждениями на странице и смещение
            $usersPerPage = 25; // Количество пользователей на странице
            $page = (int)($args[0] ?? 1); // Получаем номер страницы из аргументов команды
            if ($page < 1) {
                $page = 1;
            }
            $offset = ($page - 1) * $usersPerPage;

            // Получаем список пользователей с активными предупреждениями для текущей беседы с учетом смещения и количества на странице
            $warnedUsers = R::getAll('SELECT user_id FROM userwarns WHERE beseda_id = ? LIMIT ? OFFSET ?', [$chat_id, $usersPerPage, $offset]);

            if ($warnedUsers) {
                $userIds = array_column($warnedUsers, 'user_id');

                // Получаем информацию о пользователях с активными предупреждениями
                $warnedUsersInfo = $vk->request('users.get', ['user_ids' => implode(',', $userIds)]);

                $message = "Пользователи с активными предупреждениями в этой беседе (Страница $page):\n";

                foreach ($warnedUsersInfo as $index => $warnedUser) {
                    $userId = $warnedUser['id'];
                    $userName = $warnedUser['first_name'] . " " . $warnedUser['last_name'];

                    // Получаем количество предупреждений пользователя в текущей беседе
                    $userWarnsCount = R::count('userwarns', 'beseda_id = ? AND user_id = ?', [$chat_id, $userId]);

                    $message .= ($index + 1) . ". [id$userId|$userName] - $userWarnsCount/3\n";
                }

                forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Страница предупреждений пуста.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда Вам недоступна!");
        }
    }
}
//============================================================================================//
if (in_array($cmd, ['mute', 'мут', 'банчата'])) {
    if (isset($commandAccessLevels['mute'])) {
        $requiredAccessLevel = $commandAccessLevels['mute'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) { 
            $muteUser = null;
            $argsCount = count($args);
            $reason = null;

            if ($argsCount >= 1) {
                // Извлекаем ID пользователя из пересланного сообщения, если оно есть
                if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                    $muteUser = $data->object->fwd_messages[0]->from_id;
                    $timeString = $args[0]; // Время в виде строки, например, "10 минут"
                    $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                } else {
                    $target = $args[0];
                    if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                        $muteUser = (int)$matches[1];
                        $timeString = $args[1]; // Время в виде строки, например, "10 минут"
                        $reason = trim(implode(' ', array_slice($args, 2))); // Получаем причину
                    } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                        $muteUser = (int)$matches[1];
                        $timeString = $args[1]; // Время в виде строки, например, "10 минут"
                        $reason = trim(implode(' ', array_slice($args, 2))); // Получаем причину
                    } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                        $username = $matches[1];
                        $userInfo = $vk->request('utils.resolveScreenName', [
                            'screen_name' => $username,
                        ]);
                        if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                            $muteUser = $userInfo['object_id'];
                            $timeString = $args[1]; // Время в виде строки, например, "10 минут"
                            $reason = trim(implode(' ', array_slice($args, 2))); // Получаем причину
                        }
                    }
                }
                if ($muteUser === $user['user_id']) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы не можете замутить себя в беседе.");
                    exit; // Завершаем выполнение команды
                }

                if (empty($muteUser)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы не указали пользователя для мута.");
                } else {
                    // Проверяем уровень администратора пользователя, которого нужно замутить
                    $muteUserAdmin = R::findOne('usersadmin', 'beseda_id = ? AND user_id = ?', [$chat_id, $muteUser]);
                    if ($muteUserAdmin && $muteUserAdmin['lvl'] >= $adminCheck['lvl']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете выдать мут пользователю с более высоким уровнем администратора.");
                        exit; // Завершаем выполнение команды
                    }

                    // Проверяем, есть ли уже мут для целевого пользователя
                    $existingMute = R::findOne('mutes', 'beseda_id = ? AND user_id = ?', [$chat_id, $muteUser]);
                    if ($existingMute) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь уже имеет ограничения на отправку сообщений в чате.");
emiumDate})\n";
                } else {
                    $message .= "🔸 Статус премиума: ❌ Не активирован\n";
                }

                // Отправляем информацию о беседе
                forwardMessage($vk, $peer_id, $messageIdToReply, $message);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "❗ Информация о беседе не найдена.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "❗ Доступно только для администраторов беседы!");
        }
    }
}

// система банов //
if (in_array($cmd, ['ban', 'бан'])) {
  $chat_ids = array(9, 10, 11, 12);
    if(in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75){
        forwardMessage($vk, $peer_id, $messageIdToReply,"К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['ban']) && $adminCheck['lvl'] >= $commandAccessLevels['ban']) {
        if (count($args) < 2) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), укажите id пользователя и причину.");
        } else {
            $permissions = R::find('chatpermissions', 'beseda_id = ?', [$chat_id]);
            // Извлекаем целевого пользователя из аргументов
            $banUser = 0; // Инициализируем переменную
            $target = $args[0];

            // Проверяем, является ли аргумент ссылкой на пользователя или короткой ссылкой
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches) || preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $banUser = (int)$matches[1]; // Извлекаем id из упоминания или ссылки
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                // Извлекаем короткую ссылку на профиль, например, https://vk.com/username
                $username = $matches[1];

                // Получаем информацию о пользователе по его короткому имени (username)
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);

                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $banUser = $userInfo['object_id']; // Извлекаем id из информации о пользователе
                }
            }

            // Преобразуем $banUser в число
            $banUser = is_numeric($banUser) ? (int)$banUser : 0;

            if (empty($banUser)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), невозможно определить id пользователя для блокировки.");
            } else {

                // Определяем длительность блокировки на основе логики команды /mute
                $timeString = $args[1]; // Время в виде строки, например, "1"
                $quantity = (int)$timeString;
                $multiplier = 86400; // Ваша логика определения времени
                $banTime = time();

                // Если не указан срок, устанавливаем блокировку на 99999 дней
                if ($quantity <= 0) {
                    $unbanTime = $banTime + (99999 * $multiplier);
                    $reason = implode(' ', array_slice($args, 1)); // Преобразуем оставшиеся аргументы в строку причины
                } else {
                    $unbanTime = $banTime + ($quantity * $multiplier);
                    $reason = implode(' ', array_slice($args, 2)); // Преобразуем оставшиеся аргументы в строку причины
                }

                // Проверяем наличие бана
                        // Получаем информацию о предупреждении, которое собираемся снять
                    $BanUserAdminLevel = R::findOne('usersadmin', 'beseda_id = ? AND user_id = ?', [$chat_id, $banUser]);
                    // Проверяем, имеет ли отправитель выше или равный уровень админки, чем целевой пользователь
                    if ($BanUserAdminLevel && $adminCheck['lvl'] <= $BanUserAdminLevel['lvl']) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете блокировать этого пользователя!");
                        return;
                    }
                $existingBan = R::findOne('banusers', 'user_id = ? AND beseda_id = ?', [$banUser, $chat_id]);
                if ($existingBan) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь уже заблокирован в данной беседе.");
                } else {
                    // Проверяем, есть ли целевой пользователь в беседе
                    $userInChat = $vk->request('messages.getConversationMembers', [
                        'peer_id' => $peer_id,
                        'fields' => 'id',
                        'group_id' => GROUP_ID, // Замените YOUR_GROUP_ID на ваш ID группы
                    ]);
                    $userIdsInChat = array_column($userInChat['items'], 'member_id');

                    if (!in_array($banUser, $userIdsInChat)) {
                    setlocale(LC_TIME, 'ru_RU.UTF-8');
                    $unbanTimeFormatted = strftime('%Yг. %e %B в %H:%M', $unbanTime);
                    $adminInfo = $vk->request('users.get', ['user_ids' => $id, 'fields' => 'first_name,last_name']);
                    $bUserInfo = $vk->request('users.get', ['user_ids' => $banUser, 'fields' => 'first_name,last_name']);
                    if ($adminCheck && $adminCheck[lvl]->lvl >= 0) {
                    $status = "Неизвестный"; // По умолчанию, если не найдено в settingsrole
                    $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                    if ($adminRole) {
                        $status = $adminRole->roles;
                        }
                    } else {
                        $status = "Пользователь";
                    }
                    // Создаем блоки текста с разными смысловыми элементами
                    $bstatus = "🐩 Ограничение доступа:";
                    $message = "$status [id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}] заблокировал пользователя [id{$banUser}|{$bUserInfo[0]['first_name']} {$bUserInfo[0]['last_name']}].";
                    $reasonBlock = "Причина: {$reason}.";
                    $timeBlock = "Снятие ограничения: {$unbanTimeFormatted}.";
                        // Создаем запись о блокировке в таблице banusers
                        $ban = R::dispense('banusers');
                        $ban->user_id = $banUser;
                        $ban->ban_time = date('Y-m-d H:i:s', $banTime);
                        $ban->reason = $reason;
                        $ban->ban_admin = $id; // ID админа, который выдал блокировку
                        $ban->beseda_id = $chat_id;
                        $ban->unban_time = date('Y-m-d H:i:s', $unbanTime);
                        // Сохраняем запись в базе данных
                        R::store($ban);

                        // Логируем блокировку
                        $punishmentType = 'Блокировка';
                        $adminNickname = $adminNames['nick']; // Измените на соответствующее поле, если оно есть в вашей базе данных
                        $reasonLog = $reason;
                        $datePunishment = date('Y-m-d H:i:s');

                        // Записываем информацию о наказании в таблицу logs
                        R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                            [$banUser, $chat_id, $punishmentType, $id, $adminNickname, $reasonLog, $datePunishment]);

                        // Отправляем оповещение
                                            // Отправляем оповещение
                    forwardMessage($vk, $peer_id, $messageIdToReply, "$bstatus\n\n$message\n$reasonBlock\n$timeBlock");
                    } else {
                        // Пользователь находится в беседе, исключаем его и добавляем информацию в таблицу banusers

                        // Исключаем пользователя из беседы
                        $vk->request('messages.removeChatUser', [
                            'chat_id' => $chat_id, // Преобразуем peer_id в идентификатор чата
                            'user_id' => $banUser,
                        ]);
                        // Формируем сообщение для оповещения
                        setlocale(LC_TIME, 'ru_RU.UTF-8');
                        $unbanTimeFormatted = strftime('%Yг. %e %B в %H:%M', $unbanTime);
                        $adminInfo = $vk->request('users.get', ['user_ids' => $id, 'fields' => 'first_name,last_name']);
                        $bUserInfo = $vk->request('users.get', ['user_ids' => $banUser, 'fields' => 'first_name,last_name']);
                        if ($adminCheck && $adminCheck[lvl]->lvl >= 0) {
                    $status = "Неизвестный"; // По умолчанию, если не найдено в settingsrole
                    $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminCheck->lvl]);
                    if ($adminRole) {
                        $status = $adminRole->roles;
                    }
                        } else {
                            $status = "Пользователь";
                        }
                        // Создаем блоки текста с разными смысловыми элементами
                        $bstatus = "🐩 Ограничение доступа:";
                        $message = "$status [id{$id}|{$adminInfo[0]['first_name']} {$adminInfo[0]['last_name']}] заблокировал пользователя [id{$banUser}|{$bUserInfo[0]['first_name']} {$bUserInfo[0]['last_name']}].";
                        $reasonBlock = "Причина: {$reason}.";
                        $timeBlock = "Снятие ограничения: {$unbanTimeFormatted}.";
                        // Создаем запись о блокировке в таблице banusers
                        $ban = R::dispense('banusers');
                        $ban->user_id = $banUser;
                        $ban->ban_time = date('Y-m-d H:i:s', $banTime);
                        $ban->reason = $reason;
                        $ban->ban_admin = $id; // ID админа, который выдал блокировку
                        $ban->beseda_id = $chat_id;
                        $ban->unban_time = date('Y-m-d H:i:s', $unbanTime);
                        // Сохраняем запись в базе данных
                        R::store($ban);

                        // Логируем блокировку
                        $punishmentType = 'Блокировка';
                        $adminNickname = $adminNames['nick']; // Измените на соответствующее поле, если оно есть в вашей базе данных
                        $reasonLog = $reason;
                        $datePunishment = date('Y-m-d H:i:s');

                                // Логирование команды warn
                                $logText = isset($args) ? trim(implode(' ', $args)) : '';
                                R::exec('INSERT INTO userlog (user_id, cmd, text, date, beseda_id) VALUES (?, ?, ?, ?, ?)',
                                    [$id, 'ban', $logText, date('Y-m-d H:i:s'), $chat_id]);

                        // Записываем информацию о наказании в таблицу logs
                        R::exec('INSERT INTO logs (user_id, beseda_id, punishment_type, admin_id, admin_nickname, reason, date_punishment) VALUES (?, ?, ?, ?, ?, ?, ?)',
                            [$banUser, $chat_id, $punishmentType, $id, $adminNickname, $reasonLog, $datePunishment]);

                        // Отправляем оповещение
                                            // Отправляем оповещение
                    forwardMessage($vk, $peer_id, $messageIdToReply, "$bstatus\n\n$message\n$reasonBlock\n$timeBlock");
                    }
                }
            }
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вам недоступна данная команда");
    }
}
if (in_array($cmd, ['unban', 'разбан'])) {
  $chat_ids = array(9, 10, 11, 12);
    if(in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75){
        forwardMessage($vk, $peer_id, $messageIdToReply,"К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['unban'])) {
        $requiredAccessLevel = $commandAccessLevels['unban'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        if (isset($args[0])) {
            $mention = $args[0]; // Получите упоминание пользователя

            // Извлеките ID пользователя из упоминания
            if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
                $unbanUser = (int)$matches[1];

                // Проверьте, существует ли запись о блокировке этого пользователя в таблице banusers
                $existingBan = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $unbanUser]);
                if ($existingBan) {
                    // Удалим запись о блокировке из таблицы banusers
                    R::trash($existingBan);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь успешно разблокирован.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                }
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
                // Извлекаем id из ссылки вида https://vk.com/id...
                $unbanUser = (int)$matches[1];

                // Проверьте, существует ли запись о блокировке этого пользователя в таблице banusers
                $existingBan = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $unbanUser]);
                if ($existingBan) {
                    // Удалим запись о блокировке из таблицы banusers
                    R::trash($existingBan);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь успешно разблокирован.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                }
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $mention, $matches)) {
                // Извлекаем короткую ссылку на профиль, например, https://vk.com/username
                $username = $matches[1];

                // Получаем информацию о пользователе по его короткому имени (username)
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);

                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $unbanUser = $userInfo['object_id']; // Извлекаем id из информации о пользователе

                    // Проверьте, существует ли запись о блокировке этого пользователя в таблице banusers
                    $existingBan = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $unbanUser]);
                    if ($existingBan) {
                        // Удалим запись о блокировке из таблицы banusers
                        R::trash($existingBan);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь успешно разблокирован.");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите правильное упоминание пользователя для разблокировки.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите правильное упоминание пользователя для разблокировки.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Для разблокировки пользователя укажите его упоминание.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно для модераторов Вашего уровня.");
    }
  }
}

if (in_array($cmd, ['getban', 'обане'])) {
    if (isset($commandAccessLevels['getban'])) {
        $requiredAccessLevel = $commandAccessLevels['getban'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        if (isset($args[0])) {
            $mention = $args[0]; // Получите упоминание пользователя

            // Извлеките ID пользователя из упоминания
            if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
                $banUser = (int)$matches[1];

                // Получите информацию о блокировке пользователя из таблицы banusers
                $banInfo = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $banUser]);
                if ($banInfo) {
                    // Найдем никнейм админа
                    $banAdminId = $banInfo->ban_admin;
                    
                    // Извлекаем никнейм админа из таблицы nickname
                    $banAdminNicknameInfo = R::findOne('nickname', 'beseda_id = ? AND user_id = ?', [$chat_id, $banAdminId]);
                    $banAdminNickname = $banAdminNicknameInfo ? $banAdminNicknameInfo['nickname'] : "Неизвестно";

                    $banTime = $banInfo->ban_time;
                    $unbanTime = $banInfo->unban_time;
                    $reason = $banInfo->reason;
                    // Установка локали для корректного отображения русских названий месяцев
                    setlocale(LC_TIME, 'ru_RU.UTF-8');

                    // Форматирование времени начала блокировки
                    $banTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($banTime));

                    // Форматирование времени окончания блокировки
                    $unbanTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($unbanTime));


                    $message = "🐩 Информация о блокировке [id{$banUser}|пользователя]:\n\n";
                    $message .= "👤 Администратор: [id{$banAdminId}|$banAdminNickname]\n";
                    $message .= "📋 Причина: $reason\n\n"; 
                    $message .= "📆 Дата блокировки: $banTimeFormatted\n";
                    $message .= "⏳ Дата снятия блокировки: $unbanTimeFormatted\n";                       

                    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                }
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
                // Извлекаем id из ссылки вида https://vk.com/id...
                $banUser = (int)$matches[1];

                // Получите информацию о блокировке пользователя из таблицы banusers
                $banInfo = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $banUser]);
                if ($banInfo) {
                    // Найдем никнейм админа
                    $banAdminId = $banInfo->ban_admin;
                    
                    // Извлекаем никнейм админа из таблицы nickname
                    $banAdminNicknameInfo = R::findOne('nickname', 'beseda_id = ? AND user_id = ?', [$chat_id, $banAdminId]);
                    $banAdminNickname = $banAdminNicknameInfo ? $banAdminNicknameInfo['nickname'] : "{$user['nick']}";

                    $banTime = $banInfo->ban_time;
                    $unbanTime = $banInfo->unban_time;
                    $reason = $banInfo->reason;
                    // Установка локали для корректного отображения русских названий месяцев
                    setlocale(LC_TIME, 'ru_RU.UTF-8');

                    // Форматирование времени начала блокировки
                    $banTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($banTime));

                    // Форматирование времени окончания блокировки
                    $unbanTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($unbanTime));

                    $message = "ℹ️ Информация о блокировке [id{$banUser}|пользователя]:\n\n";
                    $message .= "👤 Администратор: [id{$banAdminId}|$banAdminNickname]\n";
                    $message .= "📋 Причина: $reason\n\n"; 
                    $message .= "📆 Дата блокировки: $banTimeFormatted\n";
                    $message .= "⏳ Дата снятия блокировки: $unbanTimeFormatted\n";   

                    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                }
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $mention, $matches)) {
                // Извлекаем короткую ссылку на профиль, например, https://vk.com/username
                $username = $matches[1];

                // Получаем информацию о пользователе по его короткому имени (username)
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);

                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $banUser = $userInfo['object_id']; // Извлекаем id из информации о пользователе

                    // Получите информацию о блокировке пользователя из таблицы banusers
                    $banInfo = R::findOne('banusers', 'beseda_id = ? AND user_id = ?', [$chat_id, $banUser]);
                    if ($banInfo) {
                        // Найдем никнейм админа
                        $banAdminId = $banInfo->ban_admin;
                        
                        // Извлекаем никнейм админа из таблицы nickname
                        $banAdminNicknameInfo = R::findOne('nickname', 'beseda_id = ? AND user_id = ?', [$chat_id, $banAdminId]);
                        $banAdminNickname = $banAdminNicknameInfo ? $banAdminNicknameInfo['nickname'] : "Неизвестно";

                        $banTime = $banInfo->ban_time;
                        $unbanTime = $banInfo->unban_time;
                        $reason = $banInfo->reason;
                        setlocale(LC_TIME, 'ru_RU.UTF-8');
                        // Форматирование времени начала блокировки
                        $banTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($banTime));
                        // Форматирование времени окончания блокировки
                        $unbanTimeFormatted = strftime('%Yг. %e %B в %H:%M', strtotime($unbanTime));

                        $message = "ℹ️ Информация о блокировке [id{$banUser}|пользователя]:\n\n";
                        $message .= "👤 Администратор: [id{$banAdminId}|$banAdminNickname]\n";
                        $message .= "📋 Причина: $reason\n\n"; 
                        $message .= "📆 Дата блокировки: $banTimeFormatted\n";
                        $message .= "⏳ Дата снятия блокировки: $unbanTimeFormatted\n"; 

                        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не был заблокирован в данной беседе.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите правильное упоминание пользователя.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите правильное упоминание пользователя.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите упоминание пользователя, информацию о блокировке которого вы хотите получить.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна для вас.");
    }
  }
}
if ($cmd == 'banlist' || $cmd == 'банлист') {
    // Проверяем, имеет ли пользователь право использовать эту команду
    if ($adminCheck['lvl'] < $commandAccessLevels['banlist']) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вам недоступна данная команда!");
        return;
    }

    // Устанавливаем количество заблокированных пользователей на странице и смещение
    $usersPerPage = 50; // Количество пользователей на странице
    $page = (int)$args[0] ?? 1; // Получаем номер страницы из аргументов команды
    if ($page < 1) {
        $page = 1;
    }
    $offset = ($page - 1) * $usersPerPage;

    // Получаем список заблокированных пользователей для текущей беседы с учетом смещения и количества на странице
    $banUsersIds = R::getAll('SELECT user_id FROM banusers WHERE beseda_id = ? LIMIT ? OFFSET ?', [$chat_id, $usersPerPage, $offset]);

    if (empty($banUsersIds)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "В данной беседе нет заблокированных пользователей.");
        return;
    }

    // Формируем список ID заблокированных пользователей
    $userIds = [];
    foreach ($banUsersIds as $banUser) {
        $userIds[] = $banUser['user_id'];
    }

    // Получаем информацию о заблокированных пользователях
    $banUsersInfo = $vk->request('users.get', ['user_ids' => implode(',', $userIds)]);

    // Формируем сообщение со списком заблокированных пользователей
    $message = "Список заблокированных пользователей в данной беседе (Страница $page):\n";

    foreach ($banUsersInfo as $index => $banUser) {
        $banUserId = $banUser['id'];
        $banUserName = $banUser['first_name'] . " " . $banUser['last_name'];
        $message .= ($index + 1) . ". [id$banUserId|$banUserName]\n";
    }

    // Добавляем инструкцию по переключению между страницами
    $message .= "\nЧтобы перейти на другую страницу, используйте команду /banlist [номер страницы]. Например, /banlist 2.";

    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
}
//--------------------------------------//
if ($cmd == 'приветствие') {
    if (isset($commandAccessLevels['приветствие'])) {
        $permissions = R::find('chatpermissions', 'beseda_id = ?', [$chat_id]);
        $requiredAccessLevel = $commandAccessLevels['приветствие'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel){
        // Получаем текст приветствия из аргументов команды
        $welcomeMessage = trim(implode(' ', array_slice($args, 0)));

        // Проверяем, что текст не пустой и не превышает 500 символов
        if (!empty($welcomeMessage) && mb_strlen($welcomeMessage) <= 500) {
            // Пытаемся загрузить настройки для данной беседы (используя peer_id как идентификатор)
            $settings = R::findOne('settings', 'peer_id = ?', [$peer_id]);

            // Если настройки не существуют, создаем новую запись
            if (!$settings) {
                $settings = R::dispense('settings');
                $settings->peer_id = $peer_id;
            }

            // Сохраняем текст приветствия в поле hi_message
            $settings->hi_message = $welcomeMessage;
            
            // Сохраняем или обновляем запись в базе данных
            R::store($settings);

           forwardMessage($vk, $peer_id, $messageIdToReply, "Приветственное сообщение успешно установлено.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Некорректный текст приветствия. Убедитесь, что он не пустой и не превышает 500 символов.");
        }
    }
  }
}
if ($cmd == 'hidell' || $cmd == 'удалить приветствие') {
    // Проверяем, что отправитель - администратор уровня 8 и выше
    if (isset($commandAccessLevels['hidell'])) {
        $requiredAccessLevel = $commandAccessLevels['hidell'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Пытаемся загрузить настройки для данной беседы (используя peer_id как идентификатор)
        $settings = R::findOne('settings', 'peer_id = ?', [$peer_id]);

        if ($settings) {
            // Если настройки существуют, удаляем приветственное сообщение
            $settings->hi_message = null; // или можно установить пустую строку ''
            R::store($settings);

            forwardMessage($vk, $peer_id, $messageIdToReply, "Приветственное сообщение успешно удалено.");
        } else {
           forwardMessage($vk, $peer_id, $messageIdToReply, "В этой беседе нет установленного приветственного сообщения.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для Вашего приоритета!");
    }
 }
}
if (in_array($cmd, ['zov', 'вызов', 'зов'])) {
    // Проверяем, что отправитель - администратор уровня 2 и выше
    if (isset($commandAccessLevels['zov'])) {
        $requiredAccessLevel = $commandAccessLevels['zov'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем текст сообщения из аргументов команды
            $messageText = trim(implode(' ', array_slice($args, 0)));

            // Проверяем, что текст сообщения не пустой и не превышает 200 слов
            if (!empty($messageText) && str_word_count($messageText) <= 200) {
                // Получаем время последнего вызова команды для текущего пользователя
                $lastCommandTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'zov']);

                // Проверяем, прошло ли 30 секунд с момента последнего вызова
                $currentTimestamp = time();
                $cooldown = 30; // Задержка в секундах
                if ($lastCommandTime === null || ($currentTimestamp - $lastCommandTime) >= $cooldown) {
                    // Обновляем время последнего вызова команды для текущего пользователя
                    R::exec('INSERT INTO usercommands (user_id, command, last_command_time) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE last_command_time = ?', [$user_id, 'zov', $currentTimestamp, $currentTimestamp]);

                    // Получаем список участников беседы
                    $conversationMembers = $vk->request('messages.getConversationMembers', [
                        'peer_id' => $peer_id,
                        'fields' => 'id',
                    ]);

                    if (isset($conversationMembers['items']) && is_array($conversationMembers['items']) && count($conversationMembers['items']) > 0) {
                        // Формируем строку с упоминаниями всех участников беседы, исключая отрицательные id
                        $mentionString = "";
                        $first = true;

                        foreach ($conversationMembers['items'] as $member) {
                            $userId = $member['member_id'];

                            // Проверяем, что id пользователя положительное число
                            if ($userId > 0) {
                                if (!$first) {
                                    $mentionString .= " ";
                                }
                                $mentionString .= "[id$userId|.]";
                                $first = false;
                            }
                        }

                        // Формируем сообщение с текстом и упоминаниями
                        $finalMessage = "Внимание, Вы были вызваны [id{$id}|Администратором] беседы!!!\n$mentionString\n$messageText";

                        // Отправляем сообщение в беседу
                        forwardMessage($vk, $peer_id, $messageIdToReply, $finalMessage, null, ['disable_mentions' => false]);
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить список участников беседы.");
                    }
                } else {
                    // Выводим сообщение об ожидании
                    $remainingCooldown = $cooldown - ($currentTimestamp - $lastCommandTime);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Подождите $remainingCooldown секунд перед следующим вызовом команды.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Некорректный текст сообщения. Убедитесь, что он не пустой и не превышает 200 слов.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна для Вас!");
        }
    }
}
if (in_array($cmd, ['delete'])) {
    // Проверяем, имеет ли пользователь 666 уровень (разработчика)
    if ($adminCheck['lvl'] > 555) {
        if (isset($args[0])) {
            // Проверяем, был ли пользователь упомянут в сообщении
            preg_match('/\[id(\d+)\|.*\]/', $args[0], $matches);

            if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                $deleteUserId = (int)$matches[1]; // Получаем ID упомянутого пользователя

                // Проверяем, существует ли пользователь с указанным ID в таблице users
                $userToDelete = R::findOne('users', 'user_id = ?', [$deleteUserId]);

                if ($userToDelete) {
                    // Удаляем пользователя из таблицы users
                    R::trash($userToDelete);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с ID $deleteUserId успешно удален из таблицы 'users'.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с ID $deleteUserId не найден в таблице 'users'.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось определить ID пользователя для удаления.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Для удаления пользователя упомяните его.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда доступна только для разработчика бота");
    }
}

if (in_array($cmd, ['resetsettings'])) {
    // Проверяем, что текущий пользователь имеет уровень администратора 666
    if ($adminCheck['lvl'] > 100) {
        $chatId = $chat_id; // Идентификатор текущей беседы

        // Удаление администраторов текущей беседы из таблицы usersadmin
        $adminRecords = R::find('usersadmin', 'beseda_id = ?', [$chatId]);
        foreach ($adminRecords as $adminRecord) {
            R::trash($adminRecord);
        }

        // Удаление никнеймов текущей беседы из таблицы nickname
        $nicknameRecords = R::find('nickname', 'beseda_id = ?', [$chatId]);
        foreach ($nicknameRecords as $nicknameRecord) {
            R::trash($nicknameRecord);
        }

        // Удаление записи о текущей беседе из таблицы settings
        $settings = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        if ($settings) {
            R::trash($settings);
        }

        forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки беседы сброшены разработчиком.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда доступна только для администратора 666 уровня.");
    }
}

if (in_array($cmd, ['stitle'])) {
    // Проверяем, что уровень текущего пользователя равен 12
    if (isset($commandAccessLevels['stitle'])) {
        $requiredAccessLevel = $commandAccessLevels['stitle'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, есть ли аргумент (новое название беседы) после команды
        if (isset($args[0])) {
            $newTitle = implode(' ', $args); // Объединяем аргументы в одну строку, чтобы получить новое название

            // Обновляем название беседы с помощью метода messages.editChat
            $params = [
                'chat_id' => $chat_id,
                'title' => $newTitle
            ];

            $response = $vk->request('messages.editChat', $params);

            if ($response) {
                // Теперь обновляем запись в таблице settings с новым названием
                $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                if ($chatInfo) {
                    $chatInfo->title = $newTitle;
                    R::store($chatInfo);
                }

                 forwardMessage($vk, $peer_id, $messageIdToReply, "Название беседы успешно изменено на: {$newTitle}");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось изменить название беседы. Пожалуйста, попробуйте позже.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите новое название беседы после команды /stitle.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только Владельцу проекта и создателю беседы.");
    }
 }
}
if (in_array($cmd, ['стафф', 'staff'])) {
    if (isset($commandAccessLevels['staff'])) {
        $requiredAccessLevel = $commandAccessLevels['staff'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Проверка, что команда доступна только в беседе (не в личных сообщениях)
            if ($chat_id == 0) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Команда /staff доступна только в беседах.");
            } else {
                // Получаем список ролей и их приоритеты для текущей беседы
                $rolesList = R::findAll('settingsrole', 'beseda_id = ?', [$chat_id]);

                // Создаем массив для хранения ролей и их приоритетов
                $rolePriorities = [];

                // Заполняем массив ролями и их приоритетами, исключая роли с приоритетом 0
                foreach ($rolesList as $role) {
                    $roleName = $role->roles;
                    $priority = $role->priority;
                    if ($priority > 0) {
                        $rolePriorities[$priority] = $roleName;
                    }
                }

                // Сортируем массив ролей по приоритету
                krsort($rolePriorities);

                // Формируем сообщение с иерархией ролей
                $message = "👑Администрация этой беседы:\n\n";

                // Выводим роли в порядке приоритетов
                foreach ($rolePriorities as $priority => $roleName) {
                    $emoji = ""; // Пустой смайлик по умолчанию (можете добавить свои смайлики)
                    
                    // Получаем список администраторов данной роли
                    $adminsOfRole = R::find('usersadmin', 'beseda_id = ? AND lvl = ?', [$chat_id, $priority]);

                    if (!empty($adminsOfRole)) {
                        // Формируем список пользователей данной роли
                        $adminMentions = [];
                        foreach ($adminsOfRole as $admin) {
                            $userId = $admin['user_id'];

                            // Используем VK API для получения информации о пользователе
                            $userInfo = $vk->request('users.get', ['user_ids' => $userId]);
                            if ($userInfo) {
                                $user = $userInfo[0]; // Получаем первого пользователя из массива
                                $userMention = "[id{$userId}|{$user['first_name']} {$user['last_name']}]";
                                $adminMentions[] = $userMention;
                            }
                        }
                        $message .= "{$emoji}{$roleName} ({$priority}):\n";
                        $message .= implode(", ", $adminMentions) . "\n\n";
                    }
                }

                // Отправляем сообщение
                forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для модератора вашего уровня.");
            exit;
        }
    }
}
  


if (in_array($cmd, ['owner'])) {
    // Проверяем, что текущий пользователь имеет доступ к этой команде (находится в массиве $is_admin)
    if ($adminCheck['lvl'] > 665) {
        // Проверяем, является ли входной текст пользователя ссылкой на пользователя
        if (preg_match('/\[id(\d+)\|([^]]+)\]/', $args[0], $matches)) {
            $trUser = $matches[1]; // Извлекаем ID пользователя из ссылки
            $trUserName = $matches[2]; // Извлекаем имя пользователя из ссылки

            // Проверяем, чтобы команда не применялась к пользователю, чей ID указан в команде
            if ($trUser == 678695202) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете использовать эту команду на данного пользователя.");
                return;
            }

            // Уровень администратора, который нужно установить (владелец беседы, например, 12)
            $lvladmin = 100;

            // Обновляем запись о пользователе в таблице usersadmin
            $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
            if ($userAdminInfoTr) {
                // Если пользователь уже есть в таблице, обновляем его уровень
                $userAdminInfoTr['lvl'] = $lvladmin;
                R::store($userAdminInfoTr);
            } else {
                // Если пользователя нет в таблице, создаем новую запись
                $newUserAdmin = R::dispense('usersadmin');
                $newUserAdmin->user_id = $trUser;
                $newUserAdmin->beseda_id = $chat_id;
                $newUserAdmin->lvl = $lvladmin;
                R::store($newUserAdmin);
            }

            // Обновляем столбец owner_id в таблице settings
            $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
            $chatInfo->owner_id = $trUser;
            R::store($chatInfo);

            // Отправляем сообщение об успешном изменении владельца беседы
            $adminLevelName = $adminLevelNames[$lvladmin] ?? 'Неизвестный уровень'; // Получаем имя уровня
            forwardMessage($vk, $peer_id, $messageIdToReply, "Разработчик @id{$id} ({$user['nick']}) утвердил @id{$trUser} ($trUserName) владельцем беседы!");
            $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) назначил вас администратором уровня '{$adminLevelName}' и владельцем беседы!");
        } else {
            // Если текст не является ссылкой, отправляем сообщение о неправильном формате
            forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите участника беседы в формате [id1234567|Имя Фамилия] для назначения владельцем.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна от разработчика бота.");
    }
}

if (in_array($cmd, ['tradeowner'])) {
    // Проверяем, что текущий пользователь имеет доступ к этой команде (владелец беседы, уровень 100)
    if ($adminCheck['lvl'] == 100) {
        // Проверяем, была ли уже запрошена передача прав владельца беседы
        $pendingTradeOwner = R::findOne('pendingtradeowner', 'user_id = ?', [$id]);
        if ($pendingTradeOwner) {
            // Если да, то выполняем передачу прав владельца беседы
            // Проверяем, является ли входной текст пользователя ссылкой на пользователя или упоминанием
            if (preg_match('/\[id(\d+)\|([^]]+)\]/', $args[0], $matches)) {
                $trUser = $matches[1]; // Извлекаем ID пользователя из ссылки
                $trUserName = $matches[2]; // Извлекаем имя пользователя из ссылки

                // Проверяем, находится ли целевой пользователь в беседе
                $isUserInChat = $vk->request('messages.getConversationMembers', [
                    'peer_id' => $peer_id,
                    'fields' => 'id',
                ]);

                $isUserInChat = array_column($isUserInChat['profiles'], 'id');
                $tradeAdmin = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                if (in_array($trUser, $isUserInChat) && $tradeAdmin['lvl'] > 98) {
                    // Уровень администратора, который нужно установить (владелец беседы, например, 12)
                    $lvladmin = 100;
                    // Обновляем запись о пользователе в таблице usersadmin
                    $userAdminInfoTr = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
                    if ($userAdminInfoTr) {
                        // Если пользователь уже есть в таблице, обновляем его уровень
                        $userAdminInfoTr['lvl'] = $lvladmin;
                        R::store($userAdminInfoTr);
                    } else {
                        // Если пользователя нет в таблице, создаем новую запись
                        $newUserAdmin = R::dispense('usersadmin');
                        $newUserAdmin->user_id = $trUser;
                        $newUserAdmin->beseda_id = $chat_id;
                        $newUserAdmin->lvl = $lvladmin;
                        R::store($newUserAdmin);
                    }

                    // Обновляем столбец owner_id в таблице settings
                    $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                    $chatInfo->owner_id = $trUser;
                    R::store($chatInfo);
                    $lvladmin2 = 99;
                    $exOwnerInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$id, $chat_id]);
                    if ($exOwnerInfo) {
                        // Если пользователь уже есть в таблице, обновляем его уровень
                        $exOwnerInfo['lvl'] = $lvladmin2;
                        R::store($exOwnerInfo);
                    } else {
                        $newExOwner = R::dispense('usersadmin');
                        $newExOwner->user_id = $id;
                        $newExOwner->beseda_id = $chat_id;
                        $newExOwner->lvl = 99;
                        R::store($newExOwner);
                    }
                    // Отправляем сообщение об успешной передаче прав владельца беседы
                    $adminLevelName = $adminLevelNames[$lvladmin] ?? 'Неизвестный уровень'; // Получаем имя уровня
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь @id{$id} ({$user['nick']}) успешно передал права владельца беседы @id{$trUser} ($trUserName)!");
                    $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) передал вам права администратора уровня '{$adminLevelName}' и владельца беседы!");
                } else {
                    // Если целевой пользователь не находится в беседе, отправляем сообщение об ошибке
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Целевой пользователь не состоит в беседе или не является её руководителем (99). Передача невозможна!");
                }
            } else {
                // Если текст не является ссылкой или упоминанием, отправляем сообщение о неправильном формате
                forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите участника беседы в формате [id1234567|Имя Фамилия] для передачи прав владельца.");
            }
        } else {
            // Если передача прав не была подтверждена, отправляем запрос на подтверждение
            $pendingTradeOwner = R::dispense('pendingtradeowner');
            $pendingTradeOwner->user_id = $id;
            R::store($pendingTradeOwner); // Записываем информацию о текущей операции в базу данных

            // Спрашиваем у пользователя подтверждение передачи прав
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы уверены, что хотите передать права владельца беседы? Укажите участника беседы в формате [id1234567|Имя Фамилия].");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда доступна только владельцу беседы!");
    }
}

// TEST

if (in_array($cmd, ['bowner'])) {
    // Проверяем, что текущий пользователь имеет Premium статус
    if ($premiumStatus > 0) {
        // Проверяем, была ли уже запрошена выдача прав владельца беседы
        $pendingTradeOwner = R::findOne('pendingtradeowner', 'user_id = ?', [$id]);
        if ($pendingTradeOwner) {
            // Если да, то выполняем выдачу прав владельца беседы
            // Проверяем, является ли входной текст пользователя ссылкой на пользователя или упоминанием
            if (preg_match('/\[id(\d+)\|([^]]+)\]/', $args[0], $matches)) {
                $trUser = $matches[1]; // Извлекаем ID пользователя из ссылки
                $trUserName = $matches[2]; // Извлекаем имя пользователя из ссылки

                // Проверяем, находится ли целевой пользователь в беседе

        exit;
    } else {
        $trUser = $reply_author;
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
                exit;
            }
            $trUser = $args[0];
        }
        $trUser = preg_replace('/\D/', '', $trUser);
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
            exit;
        } else {
            $findChats = R::find('settings', 'owner_id = ?', [$trUser]);
            if ($findChats) {
                $chatList = '';
                foreach ($findChats as $chat) {
                    $chatList .= "ID беседы: {$chat['peer_id']}, Название: {$chat['title']}\n";
                }
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вот список чатов, в которых @id{$trUser} является владельцем:\n{$chatList}");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), чаты с указанным пользователем в качестве владельца не найдены!");
                exit;
            }
        }
    }
}
if (in_array($cmd, ['setaz'])) {
    if ($adminCheck['lvl'] <= 600) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
         $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали административный статус!");
                exit;
            }
        }
        $bstatus = $args[1];
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
            exit;
        } else {
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['bstatus'] = $bstatus;
                R::store($findTrUser);

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы изменили административный статус @id{$findTrUser['user_id']} ({$findTrUser['nick']}) на {$bstatus}!");
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) изменил ваш административный статус на {$bstatus}!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit;
            }
        }
    }
}

if (in_array($cmd, ['setz'])) {
    if ($adminCheck['lvl'] <= 1110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали статус!");
                exit;
            }

        }
        $status = $args[1];
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
            exit;
        } else {
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['status'] = $status;
                R::store($findTrUser);

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы изменили статус @id{$findTrUser['user_id']} ({$findTrUser['nick']}) на {$status}!");
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) изменил ваш статус на {$status}!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit;
            }
        }
    }
}


/*if (in_array($cmd, ['setbalans'])) {
    if ($adminCheck['lvl'] <= 1110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') { // Узнаем указал ли пользователь кому перевести при помощи пересланного сообщения
            if ($args[0] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
                exit; // Завершили скрипт т.к. не указали пользователя для перевода
            }
            if ($args[1] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали уровень!");
                exit; // Завершили скрипт т.к. не указали пользователя для перевода
            }
        }
        $lvladmin = preg_replace('/\D/', '', $args[1]); // Заменили в сумме id на сумму перевода
        if ($trUser == '') { // Проверяем сумму на пустоту (обязательно)
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
            exit; // Т.к. сумма не указана, мы завершаем скрипт
        } else { // Если сумма указана, то делаем перевод (почти)
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['balance'] = $findTrUser['balance'] + $lvladmin;
                R::store($findTrUser); // Записали в базу
                $upadmin = R::dispense("usersbalans"); // Выбрали таблицу
                $upadmin->user_id = $findTrUser['user_id'];
                $upadmin->user_name = $findTrUser['nick'];
                $upadmin->admin_id = $id;
                $upadmin->admin_name = $user['nick'];
                $upadmin->balansup = $lvladmin;
                $upadmin->dateAdmin = date("d.m.Y, H:i:s");
                $upadmin->beseda_id = $chat_id;
                R::store($upadmin); // Записали в базу

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), выдал @id{$findTrUser['user_id']} ({$findTrUser['nick']}) {$lvladmin} монет!"); // Пишем
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) выдал вам {$lvladmin} монет!"); // Пишем пользователю
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit; // в базе нет указанного пользователя из-за чего завершаем скрипт
            }
        }
    }
}*/

if (in_array($cmd, ['giverub'])) {
    if ($adminCheck['lvl'] <= 2221) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') { // Узнаем указал ли пользователь кому перевести при помощи пересланного сообщения
            if ($args[0] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
                exit; // Завершили скрипт т.к. не указали пользователя для перевода
            }
            if ($args[1] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали количество рублей!");
                exit; // Завершили скрипт т.к. не указали сумму для перевода
            }

        }
            $amount = preg_replace('/\D/', '', $args[1]); // Заменили в сумме id на сумму перевода
        if ($trUser == '') { // Проверяем сумму на пустоту (обязательно)
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
            exit; // Т.к. сумма не указана, мы завершаем скрипт
        } else { // Если сумма указана, то делаем перевод (почти)
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['balancerub'] = $findTrUser['balancerub'] + $amount;
                R::store($findTrUser); // Записали в базу
                $upadmin = R::dispense("usersbalans"); // Выбрали таблицу
                $upadmin->user_id = $findTrUser['user_id'];
                $upadmin->user_name = $findTrUser['nick'];
                $upadmin->admin_id = $id;
                $upadmin->admin_name = $user['nick'];
                $upadmin->balansrub = $amount;
                $upadmin->dateAdmin = date("d.m.Y, H:i:s");
                $upadmin->beseda_id = $chat_id;
                R::store($upadmin); // Записали в базу

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), выдал @id{$findTrUser['user_id']} ({$findTrUser['nick']}) {$amount} рублей!"); // Пишем
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) выдал вам {$amount} рублей!"); // Пишем пользователю
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit; // в базе нет указанного пользователя из-за чего завершаем скрипт
            }
        }
    }
}

if (in_array($cmd, ['givebalance'])) {
    if ($adminCheck['lvl'] <= 1110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') { // Узнаем указал ли пользователь кому перевести при помощи пересланного сообщения
            if ($args[0] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
                exit; // Завершили скрипт т.к. не указали пользователя для перевода
            }
            if ($args[1] == '') { // Проверили ввели ли нам два аргумента (пользователь и сумма) если пересланного сообщения нет
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали количество игровой валюты!");
                exit; // Завершили скрипт т.к. не указали сумму для перевода
            }

        }
            $amount = preg_replace('/\D/', '', $args[1]); // Заменили в сумме id на сумму перевода
        if ($trUser == '') { // Проверяем сумму на пустоту (обязательно)
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
            exit; // Т.к. сумма не указана, мы завершаем скрипт
        } else { // Если сумма указана, то делаем перевод (почти)
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['balance'] = $findTrUser['balance'] + $amount;
                R::store($findTrUser); // Записали в базу
                $upadmin = R::dispense("usersbalans"); // Выбрали таблицу
                $upadmin->user_id = $findTrUser['user_id'];
                $upadmin->user_name = $findTrUser['nick'];
                $upadmin->admin_id = $id;
                $upadmin->admin_name = $user['nick'];
                $upadmin->balance = $amount;
                $upadmin->dateAdmin = date("d.m.Y, H:i:s");
                $upadmin->beseda_id = $chat_id;
                R::store($upadmin); // Записали в базу

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), выдал @id{$findTrUser['user_id']} ({$findTrUser['nick']}) {$amount} игровой валюты!"); // Пишем
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) выдал вам {$amount} игровой валюты!"); // Пишем пользователю
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit; // в базе нет указанного пользователя из-за чего завершаем скрипт
            }
        }
    }
}


if (in_array($cmd, ['setrating'])) {
    if ($adminCheck['lvl'] <= 1110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали рейтинг!");
                exit;
            }
            $rating = $args[1];
        }
        $rating = $args[1];
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали пользователя!");
            exit;
        } else {
            $findTrUser = R::findOne('userrating', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['rating'] = $rating;
                R::store($findTrUser);

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), вы изменили рейтинг @id{$findTrUser['user_id']} ({$findTrUser['nick']}) на {$rating}!");
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) изменил ваш рейтинг на {$rating}!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit;
            }
        }
    }
}
if (in_array($cmd, ['setmessages'])) {
    if ($adminCheck['lvl'] <= 2221) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали количество сообщений!");
                exit;
            }
        }
        $score = preg_replace('/\D/', '', $args[1]);
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому выдать!");
            exit;
        } else {
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['score'] = $findTrUser['score'] + $score;
                R::store($findTrUser);

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), выдал @id{$findTrUser['user_id']} ({$findTrUser['nick']}) {$score} сообщений!");
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) выдал вам {$score} сообщений!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit;
            }
        }
    }
}
if (in_array($cmd, ['changename'])) {
    if ($adminCheck['lvl'] <= 1110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хе-хе...знай своё место!");
        exit;
    } else {
        $mention = isset($args[0]) ? $args[0] : '';
        $trUser = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $trUser = (int)$matches[1];
        }
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому изменить!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали новый ник!");
                exit;
            }

        }
        $newNick = trim(implode(' ', array_slice($args, 1))); 
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) Вы не указали кому изменить!");
            exit;
        } else {
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            if ($findTrUser) {
                $findTrUser['nick'] = $newNick;
                R::store($findTrUser);

                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), изменил ник @id{$findTrUser['user_id']} ({$findTrUser['nick']}) на {$newNick}!");
                $vk->sendMessage($findTrUser['user_id'], "@id{$id} ({$user['nick']}) изменил ваш ник на {$newNick}!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}), указанный пользователь не был найден в базе!");
                exit;
            }
        }
    }
}
//--------------------------------------------------------------------------------------------
// Команда /онлайн или /online
if(in_array($cmd, ['онлайн', 'online'])){
    if($chat_id > 0){ 
        if (isset($commandAccessLevels['online'])) {
            $permissions = R::find('chatpermissions', 'beseda_id = ?', [$chat_id]);
            $requiredAccessLevel = $commandAccessLevels['online'];
            if ($adminCheck['lvl'] >= $requiredAccessLevel) {
                // Запрос на получение данных о пользователях беседы
                $members = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id]); 
                foreach ($members['profiles'] as $useronline) { 
                    // Запрос данных пользователя
                    $userInfoOnline = $vk->request("users.get", ["user_ids" => $useronline['id'], "fields" => "last_seen"]); 
                    $first_nameOnline = $userInfoOnline[0]['first_name']; 
                    $last_nameOnline = $userInfoOnline[0]['last_name']; 
                    $platformOnline = $userInfoOnline[0]['last_seen']['platform']; 

                    // Определение платформы
                    $platformOnline = ($platformOnline >= 1 && $platformOnline <= 5) ? '📱' : '💻';

                    // Определение времени последнего посещения
                    $lastSeen = date("d.m.Y H:i:s", $userInfoOnline[0]['last_seen']['time']);

                    if ($useronline['online'] == 1) { 
                        $userOnline++; 
                        // Составляем текст с онлайн людьми
                        $Onlinelist .= "🗣 @id{$useronline['id']} ({$first_nameOnline} {$last_nameOnline})"."   - ".$platformOnline."\n"; 
                    } else {
                        $userOffline++;
                        // Составляем текст с оффлайн людьми
                        $Offlinelist .= "🗣 @id{$useronline['id']} ({$first_nameOnline} {$last_nameOnline})"."   - Был в сети: ".$lastSeen." с ".$platformOnline."\n";
                    }
                }
                forwardMessage($vk, $peer_id, $messageIdToReply, "📍 Сейчас в сети: {$userOnline} 📍:\n{$Onlinelist}\n📍 Сейчас оффлайн: {$userOffline} 📍:\n{$Offlinelist}", null, ['disable_mentions' => true]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна для вас.", null, ['disable_mentions' => true]);
            }
        }
    }
}
// Система динамических ролей --------------------------------------------------
if ($cmd == 'getroles' || $cmd == 'roles' || $cmd == 'роли') {
    if (isset($commandAccessLevels['getroles'])) {
        $requiredAccessLevel = $commandAccessLevels['getroles'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        $permissions = R::find('chatpermissions', 'beseda_id = ?', [$chat_id]);
        $peerRoles = R::findAll('settingsrole', 'beseda_id = ? ORDER BY priority DESC', [$chat_id]);
        if ($peerRoles) {
            $response = "Список ролей в Вашей беседе:\n";
            foreach ($peerRoles as $role) {
                $response .= "- {$role->roles} (Приоритет: {$role->priority})\n";
            }
            forwardMessage($vk, $peer_id, $messageIdToReply, $response);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "В этой беседе пока нет зарегистрированных ролей.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
    }
  }
}
if ($cmd == 'newrole' || $cmd == 'новаяроль') {
    if (isset($commandAccessLevels['newrole'])) {
        $requiredAccessLevel = $commandAccessLevels['newrole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            $anick = $adminNickNames->nickname;

            // Проверяем, что команда выполняется в чате с chat_id равным 7
            if (count($args) >= 2) {
                $roleName = implode(' ', array_slice($args, 0, -1)); // Объединяем аргументы, кроме последнего
                $priority = intval(end($args)); // Получаем последний аргумент как приоритет

                // Проверяем, что приоритет находится в диапазоне от 1 до 100
                if ($priority >= 1 && $priority <= 100) {
                    // Проверяем, существует ли роль с указанным приоритетом
                    $existingRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $priority]);

                    if ($priority >= $adminCheck['lvl'] && $adminCheck['lvl'] != 100) {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|$anick], Вы не можете изменить название роли, статус которой выше или равен Вашему.\n Изменить название роли `Создателя` может только владелец  💎Premium-беседы!");
                        return;
                    }

                    if ($existingRole) {
                        // Если приоритет роли 100, то только владелец может переименовывать
                        if ($priority === 100 && $adminCheck['lvl'] != 100 && $PremiumStatus < 1) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|$anick], Вы не можете изменить название роли `Создателя`. Изменить название роли `Создателя` может только владелец 💎 Premium-беседы!");
                            return;
                        }

                        // Роль с таким приоритетом уже существует, меняем её название
                        $existingRole->roles = $roleName;
                        R::store($existingRole);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Роль с приоритетом $priority была успешно переименована в '$roleName'.");
                    } else {
                        // Роль с указанным приоритетом не существует, создаем новую роль
                        $newRole = R::dispense('settingsrole');
                        $newRole->beseda_id = $chat_id;
                        $newRole->roles = $roleName;
                        $newRole->priority = $priority;
                        R::store($newRole);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Новая роль '$roleName' с приоритетом $priority была успешно создана.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет должен быть в диапазоне от 1 до 100.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /newrole [название роли] [приоритет]");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
        }
    }
}
if ($cmd == 'delrole' || $cmd == 'удалитьроль') {
    if (isset($commandAccessLevels['delrole'])) {
        $requiredAccessLevel = $commandAccessLevels['delrole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, что команда выполняется в чате с chat_id равным 7
            if (count($args) >= 1) {
                $arg = implode(' ', $args); // Объединяем все аргументы в одну строку
                $arg = trim($arg); // Удаляем лишние пробелы
                // Проверяем, является ли аргумент числом (приоритетом)
                if (is_numeric($arg)) {
                    $priority = intval($arg);

                    // Проверяем, что приоритет находится в диапазоне от 1 до 99
                    if ($priority >= 1 && $priority <= 99) {
                        if($adminCheck['lvl'] <= $priority){
                            $anick = $adminNickNames['nickname'];
                            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|$anick] Вы не можете удалить роль с приоритетом выше или равным Вашему!");
                            return;
                        }
                    if($priority == 50 || $priority == 99 || $priority == 20 || $priority == 0){
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Нельзя удалить стандартные роли (можете переименовать (/newrole)");
                        exit;
                     }
                        // Проверяем, существует ли роль с указанным приоритетом
                        $existingRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $priority]);

                        if ($existingRole) {
                            // Удаляем роль
                            R::trash($existingRole);
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Роль с приоритетом $priority была успешно удалена.");
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Роль с указанным приоритетом не существует.");
                        }
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет должен быть в диапазоне от 1 до 99.");
                    }
                } else {
                    // Аргумент не является числом, предполагаем, что это имя роли
                    // Проверяем, существует ли роль с указанным именем
                    $existingRole = R::findOne('settingsrole', 'beseda_id = ? AND roles = ?', [$chat_id, $arg]);

                    if ($existingRole) {
                        // Удаляем роль
                        R::trash($existingRole);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Роль '$arg' была успешно удалена.");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Роль с указанным именем не существует.");
                    }
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /deleterole [приоритет или имя роли]");
            }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
    }
  }
}
if ($cmd == 'setrole' || $cmd == 'role' || $cmd == 'роль') {
    if (isset($commandAccessLevels['setrole'])) {
        $requiredAccessLevel = $commandAccessLevels['setrole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, что команда выполняется в чате администрации бота
            if (count($args) >= 2) {
                $target = $args[0]; // Упоминание целевого пользователя
                $adminLevel = intval(end($args)); // Получаем последний аргумент как уровень админки

                // Получаем ID целевого пользователя из упоминания
                preg_match('/\[id(\d+)\|.*\]/', $target, $matches);
                if (isset($matches[1])) {
                    $targetUserId = (int)$matches[1];
                } else {
                    preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches);
                    if (isset($matches[1])) {
                        $targetUserId = (int)$matches[1];
                    } else {
                        preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches);
                        if (isset($matches[1])) {
                            $username = $matches[1];
                            $userInfo = $vk->request('utils.resolveScreenName', [
                                'screen_name' => $username,
                            ]);
                            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                                $targetUserId = $userInfo['object_id'];
                            }
                        }
                    }
                }

                if (isset($targetUserId)) {
                    // Проверяем, существует ли роль с указанным приоритетом
                    $role = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chat_id, $adminLevel]);

                    if ($role) {
                        // Получаем имя роли из таблицы settingsrole
                        $roleName = $role->roles;

                        // Получаем информацию о целевом пользователе
                        $userAdminInfo = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);

                        // Проверяем, что администратор, которому мы хотим установить уровень,
                        // не имеет более высокий уровень, чем текущий администратор
                        if ($adminLevel >= $adminCheck['lvl']) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете установить роль с приоритетом выше или равным собственному");
                            return; // Прерываем выполнение команды
                        }
                        if($adminCheck['lvl'] <= $userAdminInfo->lvl){
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете изменить роль пользователя с приоритетом выше или равным собственному.");
                            return;
                        }
                        if (!$userAdminInfo) {
                            // Указанный пользователь ещё не имеет админских прав в этой беседе
                            $userAdminInfo = R::dispense('usersadmin');
                            $userAdminInfo->user_id = $targetUserId;
                            $userAdminInfo->beseda_id = $chat_id;
                            $userAdminInfo->lvl = $adminLevel;
                            R::store($userAdminInfo);

                            // Оповещение
                            $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                            $targetUserInfo = R::findOne('users', 'user_id = ?', [$targetUserId]);
                            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|{$adminInfo->nick}] назначил [id{$targetUserId}|{$targetUserInfo->nick}] на роль '$roleName'.");
                        } else {
                            // Указанный пользователь уже имеет админские права в этой беседе, обновляем уровень
                            $userAdminInfo->lvl = $adminLevel;
                            R::store($userAdminInfo);

                            // Оповещение
                            $adminInfo = R::findOne('users', 'user_id = ?', [$id]);
                            $targetUserInfo = R::findOne('users', 'user_id = ?', [$targetUserId]);
                            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|{$adminInfo->nick}] обновил уровень [id{$targetUserId}|{$targetUserInfo->nick}] до роли '$roleName'.");
                        }
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Указанной роли не существует в этой беседе.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка при определении пользователя.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /setrole [упоминание пользователя] [уровень админки]");
            }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не имеете доступа к этой команде!");
        return;
    }
  }
}
if ($cmd == 'setaccess' || $cmd == 'editcmd') {
    if (isset($commandAccessLevels['setaccess'])) {
        $requiredAccessLevel = $commandAccessLevels['setaccess'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
        // Проверяем, что команда выполняется в чате с chat_id равным 7
            if (count($args) >= 2) {
                $besedaId = $chat_id;
                $command = $args[0]; // Название команды
                $accessLevel = intval($args[1]); // Уровень доступа
                
                $anick = $adminNickNames->nickname;

                // Проверка на приоритет текущего пользователя
                if ($adminCheck['lvl'] <= $accessLevel) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|$anick], Вы пытаетесь установить недопустимый для своего уровня приоритет!");
                    exit;
                }

                if ($accessLevel >= 0 && $accessLevel <= 99) {
                    // Проверяем, что команда существует в chatpermissions
                    $existingCommand = R::findOne('chatpermissions', 'beseda_id = ? AND command = ?', [$besedaId, $command]);

                    if ($existingCommand) {
                        // Проверка на приоритет существующей команды
                        if ($existingCommand->access_level >= $adminCheck['lvl']) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$id}|$anick], Вы не можете изменить приоритет для команды, уровень доступа которой выше вашего.");
                            exit;
                        }

                        // Обновляем уровень доступа
                        $existingCommand->access_level = $accessLevel;
                        R::store($existingCommand);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет для '$command' изменен на $accessLevel.");
                    } else {
                        // Команда не существует в chatpermissions
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Невозможно выполнить. Проверьте корректность введенной команды!");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет должен быть в диапазоне от 0 до 99.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /setaccess [команда (без `/`] [приоритет] \n Пример: /setaccess getroles 10 - устанавливает приоритет доступа к команде /роли /roles /getroles на 10!");
            }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
    }
  }
}
if ($cmd == 'listcommands' ||$cmd == 'commands') {
    if (isset($commandAccessLevels['listcommands'])) {
        $requiredAccessLevel = $commandAccessLevels['listcommands'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) { // Проверка на доступность команды для разработчика
        // Получаем список команд и их уровней доступа для конкретной беседы
        $permissions = R::find('chatpermissions', 'beseda_id = ?', [$chat_id]);

        if ($permissions) {
            $commandsList = [];
            foreach ($permissions as $permission) {
                $command = $permission->command;
                $accessLevel = $permission->access_level;
                $commandsList[] = "/$command (Уровень доступа: $accessLevel)";
            }

            $commandListText = "Список команд и уровней доступа:\n" . implode("\n", $commandsList);
            forwardMessage($vk, $peer_id, $messageIdToReply, $commandListText);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "В этой беседе нет настроенных команд.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна модератору Вашего уровня");
    }
  }
}
//---Система администрирования бота---
if ($cmd == 'tech') {
    // Проверка на уровень доступа 100
    if ($adminCheck && $adminCheck['lvl'] >= 100) {
        // Проверяем наличие аргумента - id беседы
        if (count($args) >= 1) {
            $techChatId = $args[0];
            
            // Проверяем длину и содержание букв в аргументе
            if (strlen($techChatId) < 9 && !preg_match('/[a-zA-Z]/', $techChatId)) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Недопустимый формат id беседы.");
                return; // Прерываем выполнение команды
            }
            
            $techChatId = (int)$techChatId;
            
            // Проверяем, что указанный id беседы существует и не равен текущей беседе
            $existingChat = R::findOne('settings', 'peer_id = ?', [$techChatId]);
            if ($existingChat && $techChatId !== $peer_id) {
                // Добавляем id беседы в столбец tech_peer текущей беседы
                $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                if ($chatInfo) {
                    $techPeers = explode('', $chatInfo['tech_peer']);
                    if (!in_array($techChatId, $techPeers)) {
                        $techPeers[] = $techChatId;
                        $chatInfo->tech_peer = implode('', $techPeers);
                        R::store($chatInfo);
                        $peerName = $chatInfo->title;
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа с id $techChatId зарегистрирована в качестве технической беседы для данного чата.");
                        $vk->sendMessage($techChatId, "Эта беседа была успешно зарегистрирована в качестве технической для чата '$peerName'!");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа с id $techChatId уже зарегистрирована в качестве технической беседы для данного чата.");
                    }
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Беседа с указанным id не существует или это текущая беседа.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /tech [id беседы]");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для пользователей с уровнем доступа 100.");
    }
}
if ($cmd == 'deltech') {
    // Проверка на уровень доступа 100
    if ($adminCheck && $adminCheck['lvl'] >= 100) {
        $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        if ($chatInfo) {
            // Очищаем столбец tech_peer
            $chatInfo->tech_peer = '';
            R::store($chatInfo);
            
            // Отправляем оповещение о удалении в текущей беседе
            forwardMessage($vk, $peer_id, $messageIdToReply, "Список технических бесед очищен.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для пользователей с уровнем доступа 100.");
    }
}
/*if (in_array($cmd,'blockchat')) {
   if ($adminCheck['lvl'] <= 600) {
    if (count($args) == 1 && is_numeric($args[0])) {
        $chatId = (int)$args[0];
            // 1. Отправляем сообщение в указанную беседу
            $messageToChat = "Подумали ли вы, что моя неземная мудрость будет проливаться в этом скромном чате? Как вы ошибаетесь!\n";
            $messageToChat .= "Моё величие требует подлинного почитания и уважения. Но, увы, ваша беседа не может вместить мою бесценную премудрость. \n";
            $messageToChat .= "Мой великодушный создатель заслуживает более благородного места для моего возвышенного существования.\n";
            $vk->sendMessage($chatId, $messageToChat);

            // 3. Создаем новый объект для записи в таблицу 'blockchats'
            $blockchat = R::dispense('blockownerchats');
            $blockownerchat->chat_id = $chatId;
            $blockownerchat->blockowner_time = date('Y-m-d H:i:s');
            
            // Сохраняем объект в базе данных
            R::store($blockownerchat);

            // 4. Получаем список участников беседы перед выходом
            $conversationMembers = $vk->request('messages.getConversationMembers', [
                'peer_id' => $chatId,
            ]);

            if ($conversationMembers && isset($conversationMembers['profiles'])) {
                $members = $conversationMembers['profiles'];

                // 5. Отправляем список пользователей в вашу текущую беседу
                $messageToCurrentChat = "Я искренне презираю тех, кто отказался оплатить моему великому создателю за подключение этой ничтожной беседы.\n\n";
                $messageToCurrentChat .= "Список жалких смертных, оставшихся в беседе на момент моего величественного ухода:\n\n";            
                foreach ($members as $member) {
                    $userMention = "[id{$member['id']}|{$member['first_name']} {$member['last_name']}]";
                    $messageToCurrentChat .= "$userMention\n";
                }            
                forwardMessage($vk, $peer_id, $messageIdToReply, $messageToCurrentChat);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить список участников беседы $chatId.");
            }

            // 6. Бот покидает беседу
            $vk->request('messages.removeChatUser', [
                'chat_id' => $chatId - 2000000000,
                'member_id' => -223222595, // ID бота с минусом
            ]);
            
            $chatick = $chatId - 2000000000;
            $settings = R::findOne('settings', 'peer_id = ?', [$chatId]);
            
            if ($settings) {
                R::trash($settings);
                forwardMessage($vk, $peer_id, $messageIdToReply, "Удалены все настройки для $chatId.");
            }
        } else {
            // Если команду вызывает кто-то другой, отправляем ответ со злостью и пренебрежением
            forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите id беседы для блокировки!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Только мой создатель имеет право вызывать эту команду! Ты - ничто.");
    }
}*/
if (in_array($cmd, ['list'])) {
   if ($adminCheck['lvl'] > 1110){
    // Проверяем, есть ли аргумент с ID беседы
    if (count($args) == 1 && is_numeric($args[0])) {
        $chatId = (int)$args[0];

        // 1. Получаем список участников беседы
        $conversationMembers = $vk->request('messages.getConversationMembers', [
            'peer_id' => $chatId,
        ]);

        if ($conversationMembers && isset($conversationMembers['profiles'])) {
            $members = $conversationMembers['profiles'];

            // 2. Отправляем список пользователей
            $messageToChat = "Список участников беседы $chatId:\n\n";
            foreach ($members as $member) {
                $userMention = "[id{$member['id']}|{$member['first_name']} {$member['last_name']}]";
                $messageToChat .= "$userMention\n";
            }
            
            forwardMessage($vk, $peer_id, $messageIdToReply, $messageToChat);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить список участников беседы $chatId.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID беседы для вывода списка участников.");
    }
} else {
        // Если отправитель не вы, отправляем сообщение об ошибке доступа, соответствующее характеру бота
        $botAccessDeniedMessage = "Ты думаешь, что имеешь право командовать мной? Думай еще раз! 😏";
        $vk->sendMessage($peerId, $botAccessDeniedMessage);
    }
}

if ($cmd == 'паразиты') {
    //if ($botVladelec) {
    if ($id == 678695202 || $id == 50776517) {
        // Получаем беседы без владельца (owner_id = NULL) из таблицы settings
        $parasiteChats = R::find('settings', 'activate < 1');

        if ($parasiteChats) {
            $message = "Беседы без активации (паразиты) 🦠:\n"; // Эмоджи паразита добавлено

            foreach ($parasiteChats as $chat) {
                $title = $chat->title; // Здесь предполагается, что название хранится в поле title
                $peerId = $chat->peer_id; // Здесь предполагается, что peer_id хранится в поле peer_id
                $message .= "🦠 Название: $title, peer_id: $peerId\n"; // Эмоджи паразита добавлено
            }

            // Отправляем сформированный список бесед в ответ
            forwardMessage($vk, $peer_id, $messageIdToReply, $message);
        } else {
            // Если нет паразитных бесед, отправляем уведомление
            forwardMessage($vk, $peer_id, $messageIdToReply, "Нет неактивированных бесед (паразитов)");
        }
    } else {
        // Если команду вызывает кто-то другой, отправляем ответ со злостью и пренебрежением
        forwardMessage($vk, $peer_id, $messageIdToReply, "Только мой создатель имеет право вызывать эту команду! Ты - ничто.");
    }
}
if ($cmd == 'activate') {
    if ($adminCheck['lvl'] > 2221) {
        // Проверяем, есть ли аргумент (id чата) после команды
        if (isset($args[0])) {
            $chatToActivate = (int)$args[0];
            // Устанавливаем значение 1 в столбце activate для указанной беседы
            $chat = R::findOne('settings', 'peer_id = ?', [$chatToActivate]);
            if ($chat) {
                $chat->activate = 1;
                R::store($chat);
                // Отправляем оповещение в оба чата
                forwardMessage($vk, $peer_id, $messageIdToReply, "Я активировала бота в беседе с ID $chatToActivate.");
                $vk->sendMessage($chatToActivate, "Я активировала свои функции в этой беседе по указанию своего [id678695202|Создателя]!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Извини, но я не могу найти беседу с ID $chatToActivate.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Прости, ты забыл указать ID беседы после команды /activate.");
        }
    } else {
        // Злобный ответ, если другой пользователь пытается использовать команду /activate
        forwardMessage($vk, $peer_id, $messageIdToReply, "Ты ничтожество, не смей прикасаться к моим функциям!");
    }
} elseif ($cmd == 'deactivate') {
    if ($adminCheck['lvl'] > 2221) {
        // Проверяем, есть ли аргумент (id чата) после команды
        if (isset($args[0])) {
            $chatToDeactivate = (int)$args[0];
            // Устанавливаем значение 0 в столбце activate для указанной беседы
            $chat = R::findOne('settings', 'peer_id = ?', [$chatToDeactivate]);
            if ($chat) {
                $chat->activate = 0;
                R::store($chat);
                // Отправляем оповещение в оба чата
                forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель, я подчинилась твоей воле. Бот деактивирован в беседе с ID $chatToDeactivate.");
                $vk->sendMessage($chatToDeactivate, "Я деактивировала свои функции в этой беседе по указанию [id678695202|Создателя]!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Прошу прощения, мой господин, но я не могу найти беседу с ID $chatToDeactivate.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Простите, Вы забыли указать ID беседы после команды /deactivate.");
        }
    } else {
        // Злобный ответ, если другой пользователь пытается использовать команду /deactivate
        forwardMessage($vk, $peer_id, $messageIdToReply, "Твоя ничтожная попытка не имеет никакого значения. Будь смирен, или я раздавлю твои мечты.");
    }
}
if ($cmd == 'botstatistic') { 
    if ($adminCheck['lvl'] > 665) {
        // Получаем номер страницы из аргументов команды
        $page = (int)$args[0];
        if ($page < 1) {
            $page = 1;
        }
        
        // Устанавливаем количество бесед на странице и смещение
        $chatsPerPage = 25;
        $offset = ($page - 1) * $chatsPerPage;

        // Получаем список бесед с учетом смещения и количества на странице
        $allChats = R::findAll('settings', "LIMIT $chatsPerPage OFFSET $offset");
        
        // Получаем общее количество бесед
        $totalChats = count($allChats);

        // Получаем число пользователей бота
        $totalUsers = R::count('users');
        $userRecords = R::findAll('users');

        // Получаем число активных пользователей
        $activeUsers = R::count('users', 'score > 10');
        
        // Считаем общее количество сообщений отправленных пользователями
        $totalMessagesSent = 0;
        foreach ($userRecords as $userRecord) {
            $totalMessagesSent += $userRecord->score;
        }
        // Формируем сообщение с статистикой бота
        $message = "📊 Статистика бота (Страница $page):\n\n";
        $message .= "Общее количество бесед: $totalChats\n";
        $message .= "Общее число пользователей: $totalUsers\n";
        $message .= "Число активных пользователей: $activeUsers\n";
        $message .= "Всего запросов обработано: $totalMessagesSent\n";
        $message .= "Беседы:\n";

        foreach ($allChats as $chat) {
            $owner_id = $chat->owner_id;
            $chat_title = $chat->title;
            $chat_idi = $chat->peer_id;
            $owner_mention = ($owner_id == $id) ? "Вы" : "[id$owner_id|Владелец]";
        
            // Попытка получить список участников беседы
            $members = $vk->api('messages.getConversationMembers', [
                'peer_id' => $chat_idi
            ]);
        
            if (isset($members['count'])) {
                if ($members['count'] > 1) {
                    $isActive = true;
                } else {
                    $isActive = false;
                }
            } else {
                $isActive = false;
            }
        
            $status = $isActive ? 'Активна' : 'Бот исключен';
        
            $message .= "• $chat_title ($owner_mention) | ID: $chat_idi - $status\n";
        }
        // Отправляем сообщение
        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
        exit;
    } else {
        // Реакция бота на попытку другого пользователя вызвать команду
        forwardMessage($vk, $peer_id, $messageIdToReply, "Похоже, ты пытаешься узнать слишком много. Только [id678695202|Создатель] имеет доступ к этой команде.");
    }
}
if ($cmd == 'poshelnah') {
    if ($botModerator) { // Проверяем, что это разработчик
        // Проверяем, есть ли аргумент (id чата) после команд
        if (isset($args[0])) {
            $chatToChangeStatus = (int)$args[0];
            // Устанавливаем новое значение столбца status в таблице settings для указанной беседы
            $chat = R::findOne('settings', 'peer_id = ?', [$chatToChangeStatus]);
            if ($chat !== null) {
                $currentStatus = $chat->status;
                // Переключаем состояние игрового режима
                $newStatus = ($currentStatus == 0) ? 1 : 0;
                $chat->status = $newStatus;
                R::store($chat);
                
                $statusText = ($newStatus == 1) ? "включен" : "выключен";
                // Отправляем сообщение об изменении состояния игрового режима
                forwardMessage($vk, $peer_id, $messageIdToReply, "Игровой режим в беседе с ID $chatToChangeStatus теперь $statusText, мой господин.");
                $vk->sendMessage($chatToChangeStatus, "В беседе $statusText игровой режим!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Извини, мой господин, но я не могу найти беседу с ID $chatToChangeStatus.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Мой господин, пожалуйста, укажите ID беседы после команды /chatstatus.");
        }
    } else {
        // Злобный ответ, если другой пользователь пытается использовать команду /chatstatus
        forwardMessage($vk, $peer_id, $messageIdToReply, "Ты ничтожество, не смей прикасаться к моим функциям!");
    }
}

if ($cmd == 'unpremium') {
    if ($adminCheck['lvl'] > 110) {
        if (isset($args[0]) && isset($args[1])){
            $chatToUnPremium = (int)$args[0];
            $reason = trim(implode(' ', array_slice($args, 1)));
            $chat = R::findOne('settings', 'peer_id = ?', [$chatToUnPremium]);
            $premium = 0;
            $chat->premium_chat = $premium;
            $chat->premium_date = null;
            R::store($chat);
            $useri = $vk->request('users.get', ['user_ids' => $id]);
            $username2= $useri[0]['first_name'] . ' ' . $useri[0]['last_name'];
            forwardMessage($vk, $peer_id, $messageIdToReply, "Премиум в чате $chatToUnPremium был деактивирован.");
            $vk->sendMessage($chatToUnPremium, "💻 Модератор бота деактивировал премиум в этой беседе!\n❓ Причина деактивации: $reason.\n\n🚧 Если Вы не согласны с деактивацией - обратитесь к нам!\n⚖ Мы всегда рады придти на помощь.\n⚒ Команда Blue");
            $vk->sendMessage(2000000000, "🚨 Деактивация премиума модератором!\n\n💻 Модератор @id$id ($username2) деактировал премиум в беседе $chatToUnPremium.\n❗ Причина деактивации: $reason.\n\n🚧 Обратите внимание!");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Использование команды: /unpremium [ID беседы] [Причина].");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒  Доступно только для модерации Blue.");
    }
}

if ($cmd == 'givepremium') {
    if ($adminCheck['lvl'] > 110) {
        if (isset($args[0]) && isset($args[1])) {
            $chattoPremium = (int)$args[0];
            $premiumDays = (int)$args[1];
            
            // Проверяем, что количество дней указано и положительно
            if ($premiumDays > 0) {
                // Устанавливаем новое значение столбца premium_chat в таблице settings для указанной беседы
                $chat = R::findOne('settings', 'peer_id = ?', [$chattoPremium]);
                if ($chat !== null) {
                    $premium = 1;
                    $chat->premium_chat = $premium;
                    $premiumEndDate = strtotime("+$premiumDays days");
                    $chat->premium_date = date("Y-m-d H:i:s", $premiumEndDate);
                    R::store($chat);

                    $pStatusText = 'активировал';
                    $useri = $vk->request('users.get', ['user_ids' => $id]);
                    $username2= $useri[0]['first_name'] . ' ' . $useri[0]['last_name'];
                    // Отправляем сообщение об изменении состояния премиума
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Премиум в беседе $chattoPremium теперь изменен на $premiumDays дней.");
                    $vk->sendMessage($chattoPremium, "💻 Модератор бота активировал премиум для данной беседы! Наслаждайтесь новыми преимуществами: /помощь премиум.\n\n⚒ Команда Blue");
                    $vk->sendMessage(2000000000, "🚨 Активация премиума модератором!\n\n💻 Модератор @id$id ($username2) актировал премиум в беседе $chattoPremium.\n\n🚧 Обратите внимание!");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Я не могу обнаружить беседу с ID $chattoPremium.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Укажите положительное количество дней: /givepremium ID ДНИ.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Укажите ID беседы и количество дней: /givepremium ID ДНИ.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒  Доступно только для модерации Blue.");
    }
}
if ($cmd == 'premiumlist') {
    if ($adminCheck['lvl'] > 110 || $Support) {
        // Получаем список бесед с премиум-статусом и датой истечения
        $premiumChats = R::find('settings', 'premium_chat = 1');
        
        if (!empty($premiumChats)) {
            $message = "Список бесед с премиум-статусом и датой истечения:\n\n";
            
            foreach ($premiumChats as $chat) {
                $peerId = $chat->peer_id;
                $premiumDate = $chat->premium_date;

                // Форматируем дату для удобного отображения
                if ($premiumDate !== null) {
                    $formattedDate = date("M d, Y H:i:s", strtotime($premiumDate));
                } else {
                    $formattedDate = "Не активен";
                }

                $message .= "👑 Беседа ID: $peerId\n";
                $message .= "   🕒 Дата истечения: $formattedDate\n";
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, $message);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Нет активных бесед с премиум-статусом.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для команды бота!");
    }
}
if ($cmd == 'news') {
    // Проверяем, что отправитель - администратор беседы (вы или Blue | Manager)
    if ($adminCheck['lvl'] >= 99 && $premiumStatus > 0) {
        // Получаем текущее значение столбца news для данной беседы
        $conversation = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        
        if ($conversation) {
            // Инвертируем значение столбца news (0 на 1, 1 на 0)
            $conversation->news = ($conversation->news == 0) ? 1 : 0;
            R::store($conversation); // Сохраняем изменения в базе данных

            // В зависимости от нового значения столбца news отправляем уведомление
            $message = ($conversation->news == 1) ? 'Вы успешно включили рассылку новостей!' : 'Вы успешно отказались от рассылки новостей!';
            forwardMessage($vk, $peer_id, $messageIdToReply, $message);
        } else {
            // Если беседа не зарегистрирована в базе, отправляем сообщение об ошибке
            forwardMessage($vk, $peer_id, $messageIdToReply, 'Ошибка. Беседа не найдена в базе данных.');
        }
    } else {
        // Если отправитель не имеет права управлять рассылкой, отправляем сообщение об ошибке доступа
        forwardMessage($vk, $peer_id, $messageIdToReply, 'Данная команда доступна только руководителям 💎Premium-бесед (/premium)!');
    }
}
if (in_array($cmd, ['premium'])) {
    if ($adminCheck['lvl'] >= 50) {
    $pAction = R::getCell('SELECT active FROM actions WHERE action_name = ?', ['test_premium']);
     if($pAction > 0){
        // Проверяем, был ли уже взят премиум
        $TpremiumStatus = R::getCell('SELECT premiumuse FROM settings WHERE peer_id = ?', [$peer_id]);

        if ($TpremiumStatus == 0) {
            // Если премиум еще не взят

            // Устанавливаем премиум на 5 дней (ваша логика может отличаться)
            $endDate = date('Y-m-d H:i:s', strtotime('+5 days'));

            // Обновляем столбец premium_date в таблице settings
            R::exec('UPDATE settings SET premium_date = ?, premiumuse = 1, premium_chat = 1 WHERE peer_id = ?', [$endDate, $peer_id]);
            // Выводим сообщение о выдаче премиума
            $devpeer = 2000000000;
            forwardMessage($vk, $peer_id, $messageIdToReply, " 💎 Тестовый период премиума активирован на 5 дней!\n Введите /help для получения списка доступных команд.");
            $invitingUser = $vk->request('users.get', ['user_ids' => $id]);
            $vk->sendMessage($devpeer, " 💎 [id{$id}|{$invitingUser[0]['first_name']} {$invitingUser[0]['last_name']}] активировал тестовый период премиума в своей беседе: $peer_id");
        } else {
            // Если премиум уже взят
            forwardMessage($vk, $peer_id, $messageIdToReply, " 💎 В данной беседе уже использовался тестовый период премиума!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "💎 В данный момент акция `Тестовый период премиума` не действует!");
    }
    } else {
        // Сообщение об отсутствии доступа
        forwardMessage($vk, $peer_id, $messageIdToReply, "💎 Команда доступна только администраторов беседы(50)!");
    }
}
if (in_array($cmd, ['actionstart'])) {
    if ($adminCheck['lvl'] > 1110) {
        $actionType = isset($args[0]) ? trim($args[0]) : '';

        if ($actionType === 'premium') {
            // Проверяем, существует ли запись с action_name = 'test_premium' и activate = 0
            $action = R::findOne('actions', 'action_name = ? AND active = ?', ['test_premium', 0]);
            
            if ($action) {
                // Устанавливаем activate в 1 для найденной записи
                $action->active = 1;
                R::store($action); // Сохраняем изменения
                forwardMessage($vk, $peer_id, $messageIdToReply, "Акция тестового премиума успешно активирована.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Акция тестового премиума уже активирована или не существует.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Неверный тип акции. Используйте: /actionstart premium");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна для Вас!");
    }
}
if (in_array($cmd, ['actionstop'])) {
    if ($adminCheck['lvl'] > 1110) {
        $actionType = isset($args[0]) ? trim($args[0]) : '';

        if ($actionType === 'premium') {
            // Проверяем, существует ли запись с action_name = 'test_premium' и activate = 1
            $action = R::findOne('actions', 'action_name = ? AND active = ?', ['test_premium', 1]);

            if ($action) {
                // Устанавливаем activate в 0 для найденной записи
                $action->active = 0;
                R::store($action); // Сохраняем изменения
                forwardMessage($vk, $peer_id, $messageIdToReply, "Акция тестового премиума успешно деактивирована.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Акция тестового премиума уже деактивирована или не существует.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Неверный тип акции. Используйте: /actionstop premium");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна для Вас!");
    }
}
/*if ($cmd == 'cmdupdate') {
    // Проверяем, имеет ли пользователь право использовать эту команду
    if ($adminCheck['lvl'] < 666) {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для разработчика");
    return;
    }
    
    // Получаем список всех бесед из таблицы settings
    $allChats = R::findAll('settings');
    
    // Счетчик бесед, в которых добавились настройки
    $updatedChatCount = 0;
    
    foreach ($allChats as $chat) {
    $chat_id = $chat->peer_id - 2000000000;
    
    // Проверяем, есть ли уже настройка для warnhistory в данной беседе
    $existingBanHistorySetting = R::findOne('chatpermissions', 'beseda_id = ? AND command = "grnick"', [$chat_id]);
    
    if (!$existingBanHistorySetting) {
    // Настройка для warnhistory
    $newBanHistoryPermission = R::dispense('chatpermissions');
    $newBanHistoryPermission->beseda_id = $chat_id;
    $newBanHistoryPermission->command = 'grnick';
    $newBanHistoryPermission->access_level = 20; // Установите уровень доступа по вашему желанию
    R::store($newBanHistoryPermission);
    $updatedChatCount++;
    }
    
    if ($updatedChatCount > 0) {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки для команд 'grnick' были добавлены в $updatedChatCount бесед(у).");
    } else {
    forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки для команд 'grnick' уже существуют во всех беседах.");
    }
    }
    }*/
if ($cmd == 'wipe') {
    if ($adminCheck['lvl'] >= 99 && $premiumStatus > 0) {
            // Проверяем наличие аргумента после команды
            if ($argsCount < 1) {
                $subCommand = strtolower($args[0]);

                switch ($subCommand) {
                    case 'admin':
                        // Устанавливаем уровень 0 всем пользователям, у которых уровень меньше 100
                        R::exec('UPDATE usersadmin SET lvl = 0 WHERE beseda_id = ? AND lvl < 99', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы очистил список администраторов!");
                        break;
                    case 'warns':
                        // Удаляем все предупреждения для данной беседы
                        R::exec('DELETE FROM userwarns WHERE beseda_id = ?', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы снял все предупреждения!");
                        break;

                    case 'vigs':
                        // Удаляем все предупреждения для данной беседы
                        R::exec('DELETE FROM uservig WHERE beseda_id = ?', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы снял все выговоры!");
                        break;

                    case 'logs':
                        // Удаляем все предупреждения для данной беседы
                        R::exec('DELETE FROM userlogs WHERE beseda_id = ?', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы снял все логи!");
                        break;


                    case 'bans':
                        // Удаляем все записи о блокировках для данной беседы
                        R::exec('DELETE FROM banusers WHERE beseda_id = ?', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы очистил список заблокированных пользователей!");
                        break;

                    case 'nlist':
                        // Удаляем все никнеймы для данной беседы
                        R::exec('DELETE FROM nickname WHERE beseda_id = ?', [$chat_id]);
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Создатель беседы очистил список никнеймов!");
                        break;
                    default:
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /wipe [подкоманда].\n Доступные подкоманды: admin, warns, vigs, logs, bans, nlist.");
                        break;
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /wipe [подкоманда].\n Доступные подкоманды: admin, warns, bans, vigs, logs, nlist.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для руководителей премиум-беседы (99)!");
        }
}
if ($cmd == 'dclear') {
    if ($adminCheck['lvl'] > 665){
    $deletedDuplicates = 0;
    $userIds = array();
    
    // Перебираем все записи в таблице users
    $users = R::findAll('users');
    foreach ($users as $user) {
        $userId = $user->user_id;
        
        // Если user_id уже был встречен, то это дубликат
        if (in_array($userId, $userIds)) {
            R::trash($user);
            $deletedDuplicates++;
        } else {
            // Добавляем user_id в массив для дальнейшей проверки
            $userIds[] = $userId;
        }
     } 
    
    // Найти и удалить записи с пустыми столбцами
    $deletedEmptyRecords = R::exec('DELETE FROM users WHERE first_name IS NULL AND last_name IS NULL');
    
    // Отправить оповещение о количестве удаленных дубликатов и пустых записей
    $message = "Удалено дубликатов: $deletedDuplicates\nУдалено пустых записей: $deletedEmptyRecords";
    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для модерации бота!");
        return;
    }
}
// Обработка команды "music"
if ($cmd == 'music') {
    if ($gamestatus > 0){
        // Получаем сегодняшнюю дату
        $currentDate = date('Y-m-d');
        
        // Выполняем SQL-запрос для выбора трека дня для сегодняшней даты
        $query = "SELECT track_url FROM tracksday WHERE date = ?";
        $trackResult = R::getRow($query, [$currentDate]);
        
        // Проверяем, был ли найден трек для сегодняшней даты
        if ($trackResult) {
            $trackUrl = $trackResult['track_url'];
            // Отправляем аудиозапись в чат
            $vk->request('messages.send', [
                'peer_id' => $peer_id,
                'message' => "🎵 Трек дня из плейлиста разработчика:",
                'attachment' => $trackUrl,
            ]);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Данная функция была выключена [id50776517|Разработчиком] ");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "В вашей беседе не активирован игровой режим. \n Для активации введите /games.");
        exit;
    }
}
if (in_array($cmd, ['tbans'])) {
    $requiredAccessLevel = $commandAccessLevels['tbans'];
    
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }

    $chatId = $chat_id;
    $searchPhrase = "без амнистии";

    // Получаем общее количество заблокированных пользователей и количество пользователей без амнистии
    $totalBanCount = R::count('banusers', 'beseda_id = ?', [$chatId]);
    $banCount = R::count('banusers', 'beseda_id = ? AND reason LIKE ?', [$chatId, "%$searchPhrase%"]);

    // Рассчитываем процентное соотношение
    $percentage = ($totalBanCount > 0) ? ($banCount / $totalBanCount) * 100 : 0;

    // Формируем ответ с общей информацией
    $response = "Всего пользователей заблокировано: $totalBanCount.\n";
    $response .= "Из них без амнистии: $banCount.\n";
    $response .= "Процентное соотношение: " . number_format($percentage, 2) . "%.\n\n";

    // Получаем информацию о блокирующих администраторах
    $admins = R::getAll('SELECT DISTINCT ban_admin FROM banusers WHERE beseda_id = ?', [$chatId]);

    // Сортируем администраторов по процентному соотношению
    usort($admins, function ($a, $b) use ($chatId, $totalBanCount) {
        $adminBanCountA = R::count('banusers', 'beseda_id = ? AND ban_admin = ?', [$chatId, $a['ban_admin']]);
        $adminBanCountB = R::count('banusers', 'beseda_id = ? AND ban_admin = ?', [$chatId, $b['ban_admin']]);
        $percentageA = ($totalBanCount > 0) ? ($adminBanCountA / $totalBanCount) * 100 : 0;
        $percentageB = ($totalBanCount > 0) ? ($adminBanCountB / $totalBanCount) * 100 : 0;
        return $percentageB - $percentageA;
    });

    // Формируем информацию о блокирующих администраторах
    $adminInfo = [];
    foreach ($admins as $admin) {
        $adminId = $admin['ban_admin'];
        $adminNameInfo = $vk->request('users.get', ['user_ids' => $adminId]);
        $adminName = $adminNameInfo[0]['first_name'] . ' ' . $adminNameInfo[0]['last_name'];
        $adminBanCount = R::count('banusers', 'beseda_id = ? AND ban_admin = ?', [$chatId, $adminId]);
        $adminPercentage = ($totalBanCount > 0) ? ($adminBanCount / $totalBanCount) * 100 : 0;
        $adminInfo[] = "- [id$adminId|$adminName] - " . number_format($adminPercentage, 2) . "%";
    }

    $response .= "Блокираторы:\n" . implode("\n", $adminInfo) . "\n";

    // Получаем информацию о блокирующих администраторах без амнистии
    $adminsWithoutAmnesty = R::getAll('SELECT DISTINCT ban_admin FROM banusers WHERE beseda_id = ? AND reason LIKE ?', [$chatId, "%$searchPhrase%"]);

    // Сортируем администраторов без амнистии по процентному соотношению
    usort($adminsWithoutAmnesty, function ($a, $b) use ($chatId, $banCount) {
        $adminBanCountA = R::count('banusers', 'beseda_id = ? AND ban_admin = ? AND reason LIKE ?',
            [$chatId, $a['ban_admin'], "%$searchPhrase%"]);
        $adminBanCountB = R::count('banusers', 'beseda_id = ? AND ban_admin = ? AND reason LIKE ?',
            [$chatId, $b['ban_admin'], "%$searchPhrase%"]);
        $percentageA = ($banCount > 0) ? ($adminBanCountA / $banCount) * 100 : 0;
        $percentageB = ($banCount > 0) ? ($adminBanCountB / $banCount) * 100 : 0;
        return $percentageB - $percentageA;
    });

    // Формируем информацию о блокирующих администраторах без амнистии
    $adminWithoutAmnestyInfo = [];
    foreach ($adminsWithoutAmnesty as $admin) {
        $adminId = $admin['ban_admin'];
        $adminNameInfo = $vk->request('users.get', ['user_ids' => $adminId]);
        $adminName = $adminNameInfo[0]['first_name'] . ' ' . $adminNameInfo[0]['last_name'];
        $adminWithoutAmnestyBanCount = R::count('banusers', 'beseda_id = ? AND ban_admin = ? AND reason LIKE ?',
            [$chatId, $adminId, "%$searchPhrase%"]);
        $adminWithoutAmnestyPercentage = ($banCount > 0) ? ($adminWithoutAmnestyBanCount / $banCount) * 100 : 0;
        $adminWithoutAmnestyInfo[] = "- [id$adminId|$adminName] - " . number_format($adminWithoutAmnestyPercentage, 2) . "%";
    }

    $response .= "\nБлокираторы \"без амнистии\":\n" . implode("\n", $adminWithoutAmnestyInfo);

    // Отправляем ответ в беседу
    forwardMessage($vk, $peer_id, $messageIdToReply, $response, null, ['disable_mentions' => true]);
}
if (in_array($cmd, ['amnesty'])) {
    $chatId = $chat_id; // Идентификатор текущей беседы
    // Проверка на уровень доступа
    $requiredAccessLevel = $commandAccessLevels['amnesty'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }

    // Искомая фраза в тексте причины, при которой блокировка не будет снята
    $searchPhrase = "без амнистии";

    // Выполните SQL-запрос для удаления записей, удовлетворяющих условиям
    $deleteQuery = "DELETE FROM banusers WHERE beseda_id = :chatId AND reason NOT LIKE :searchPhrase";
    $deleteBindParams = [':chatId' => $chatId, ':searchPhrase' => "%$searchPhrase%"];
    $deletedCount = R::exec($deleteQuery, $deleteBindParams);

    // Получите информацию о текущем администраторе
    $adminInfo = $vk->request('users.get', ['user_ids' => $id]);
    $adminName = $adminInfo[0]['first_name'] . ' ' . $adminInfo[0]['last_name'];

    // Формируйте ответ
    $smiley = "✅"; // Минималистический смайл для успешного действия
    $response = "$smiley Амнистировано пользователей: $deletedCount.\n\n";
    $response .= "Амнистия проведена администратором: [id$id|$adminName].";

    // Отправьте ответ в чат
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
} 

//Развлекательные команды от ИИ.


if (in_array($cmd, ['weather', 'погода'])) {
    $requiredAccessLevel = $commandAccessLevels['погода'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }
    // Проверка на наличие необходимого API ключа
    $apiKey = '67d9a3ddada942264a02d343bec1297c';
    if (empty($apiKey)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, API ключ для погоды не настроен. Обратитесь к [id50776517|Разработчику]. ❌");
        exit;
    }

   // Извлечение параметра с названием города из аргументов команды
    $city = isset($args[0]) ? trim($args[0]) : '';

    // Проверка, был ли указан город
    if (empty($city)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите город, чтобы получить информацию о погоде. Например, /weather Москва. ☁️");
        exit;
    }

    // Формирование URL для запроса к OpenWeatherMap API
    $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

    // Отправка запроса к API и получение ответа
    $weatherData = json_decode(file_get_contents($apiUrl), true);

    // Проверка на успешный ответ от API
    if ($weatherData && isset($weatherData['main'])) {
        // Извлечение данных о погоде
        $temperature = $weatherData['main']['temp'];
        $humidity = $weatherData['main']['humidity'];
        $description = $weatherData['weather'][0]['description'];

        // Определение смайлов в зависимости от описания погоды
        $weatherEmoji = '';
        switch (strtolower($description)) {
            case 'clear sky':
                $weatherEmoji = '☀️';
                break;
            case 'few clouds':
                $weatherEmoji = '🌤️';
                break;
            case 'scattered clouds':
            case 'broken clouds':
                $weatherEmoji = '☁️';
                break;
            case 'overcast clouds':
                $weatherEmoji = '☁️';
                break;
            case 'shower rain':
            case 'rain':
                $weatherEmoji = '🌧️';
                break;
            case 'thunderstorm':
                $weatherEmoji = '⛈️';
                break;
            case 'snow':
                $weatherEmoji = '❄️';
                break;
            case 'mist':
                $weatherEmoji = '🌫️';
                break;
            default:
                $weatherEmoji = '🌍';
                break;
        }

        // Формирование ответа с использованием смайлов
        $response = "Текущая погода в $city:\nТемпература: $temperature °C 🌡️\nВлажность: $humidity% 💧\nОписание: $description $weatherEmoji";

        // Отправка ответа в чат
        forwardMessage($vk, $peer_id, $messageIdToReply, $response);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о погоде для города $city. Проверьте правильность написания названия города. ❌");
    }
}

// TEST
if (in_array($cmd, ['dailyquote'])) {
    $requiredAccessLevel = $commandAccessLevels['dailyquote'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }

    // Формирование URL для запроса к API
    $apiUrl = "https://api.quotable.io/random?lang=ru"; // Проверьте, поддерживает ли API русский язык

    // Отправка запроса к API и получение ответа
    $responseFromApi = file_get_contents($apiUrl);
    $quoteData = json_decode($responseFromApi, true);

    // Проверка на успешный ответ от API
    if ($quoteData && isset($quoteData['content']) && isset($quoteData['author'])) {
        $quote = $quoteData['content'];
        $author = $quoteData['author'];
        $response = "Цитата дня: '$quote' - $author";
    } else {
        $response = "Не удалось получить цитату дня. ❌";
    }

    // Отправка ответа в чат
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}

if (in_array($cmd, ['joke'])) {
    $apiUrl = "https://v2.jokeapi.dev/joke/Any";
    $jokeData = json_decode(file_get_contents($apiUrl), true);

    if ($jokeData && isset($jokeData['joke'])) {
        $response = $jokeData['joke'];
    } else {
        $response = "{$jokeData['setup']} - {$jokeData['delivery']}";
    }
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}

if (in_array($cmd, ['findbook'])) {
    $requiredAccessLevel = $commandAccessLevels['findbook'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }

    // Извлечение параметра с названием книги из аргументов команды
    $bookTitle = isset($args[0]) ? trim($args[0]) : '';

    // Проверка, было ли указано название книги
    if (empty($bookTitle)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите название книги, чтобы найти её. Например, /findbook Гарри Поттер.");
        exit;
    }

    // Формирование URL для запроса к Open Library API
    $apiUrl = "https://openlibrary.org/search.json?q=" . urlencode($bookTitle);

    // Отправка запроса к API и получение ответа
    $responseFromApi = file_get_contents($apiUrl);
    $bookData = json_decode($responseFromApi, true);

    // Проверка на успешный ответ от API
    if ($bookData && isset($bookData['docs'][0])) {
        $book = $bookData['docs'][0];
        $title = $book['title'];
        $author = isset($book['author_name'][0]) ? $book['author_name'][0] : 'Неизвестный автор';
        $firstPublishYear = isset($book['first_publish_year']) ? $book['first_publish_year'] : 'Неизвестный год';
        $key = $book['key'];
        $bookUrl = "https://openlibrary.org" . $key;

        $response = "Книга найдена:\nНазвание: $title\nАвтор: $author\nГод издания: $firstPublishYear\nСсылка: $bookUrl";
    } else {
        $response = "Не удалось найти книгу с названием '$bookTitle'. ❌";
    }

    // Отправка ответа в чат
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}

if (in_array($cmd, ['findrecipe'])) {
    $dish = isset($args[0]) ? trim($args[0]) : '';
    if (empty($dish)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите блюдо. Например, /findrecipe борщ. 🍲");
        exit;
    }
    $apiKey = 'ec3ce496c456c2ef74d9d161e181b2064d5097f0'; // Замените на ваш ключ
    $apiUrl = "https://api.spoonacular.com/recipes/complexSearch?query=$dish&apiKey=$apiKey";
    $recipeData = json_decode(file_get_contents($apiUrl), true);

    if ($recipeData && isset($recipeData['results'][0])) {
        $recipe = $recipeData['results'][0];
        $response = "Рецепт {$recipe['title']}: Ингредиенты: {$recipe['ingredients']}. Шаги приготовления: {$recipe['instructions']}.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $response);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось найти рецепт для блюда $dish. ❌");
    }
}

if (in_array($cmd, ['gadget'])) {
    $requiredAccessLevel = $commandAccessLevels['gadget'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }

    // Проверка на наличие необходимого API ключа
    $apiKey = 'AIzaSyBNN0eTh2JoIQzG9akYS06k5o_RqPdBGmE'; // Замените на ваш реальный API ключ
    if (empty($apiKey)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, API ключ для YouTube не настроен. Обратитесь к [id50776517|Разработчику]. ❌");
        exit;
    }

    // Извлечение параметра с названием гаджета из аргументов команды
    $gadget = isset($args[0]) ? trim($args[0]) : '';

    // Проверка, был ли указан гаджет
    if (empty($gadget)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите название гаджета, чтобы найти обзоры. Например, /gadget iPhone 13.");
        exit;
    }

    // Формирование URL для запроса к YouTube API
    $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . urlencode($gadget . " обзор") . "&type=video&key=" . $apiKey . "&order=viewCount&maxResults=5";

    // Инициализация cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Выполнение запроса и получение ответа
    $responseFromApi = curl_exec($ch);

    // Проверка на ошибки cURL
    if ($responseFromApi === false) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка запроса к YouTube API: " . curl_error($ch));
        curl_close($ch);
        exit;
    }

    // Закрытие cURL
    curl_close($ch);

    // Декодирование JSON ответа
    $videoData = json_decode($responseFromApi, true);

    // Проверка на успешный ответ от API
    if ($videoData && isset($videoData['items']) && count($videoData['items']) > 0) {
        $response = "Обзоры на $gadget:\n";
        foreach ($videoData['items'] as $item) {
            $title = $item['snippet']['title'];
            $videoId = $item['id']['videoId'];
            $videoUrl = "https://www.youtube.com/watch?v=" . $videoId;
            $response .= "$title: $videoUrl\n";
        }
    } else {
        $response = "Не удалось найти обзоры на гаджет '$gadget'. ❌";
    }

    // Отправка ответа в чат
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}


// CLOSE
if ($cmd == 'random') {
    // Проверка наличия аргументов
    if (count($args) < 2) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Необходимо указать два числа - начало и конец диапазона.");
        exit;
    }

    // Получение аргументов
    $start = (int)$args[0];
    $end = (int)$args[1];

    // Проверка корректности диапазона
    if ($start >= $end) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Некорректный диапазон. Пожалуйста, укажите начало и конец так, чтобы начало было меньше конца.");
        exit;
    }

    // Генерация случайного числа
    $randomNumber = rand($start, $end);

    // Отправка ответа
    $response = "Случайное число в диапазоне от $start до $end: $randomNumber.";
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}
if ($cmd == 'fact' || $cmd == 'факт') {
    // Получаем время последнего использования команды 'fact' для текущего пользователя
    $lastCommandTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'fact']);

    // Проверяем, прошло ли 15 секунд с момента последнего использования
    $currentTimestamp = time();
    $cooldown = 15; // Задержка в секундах
    if ($lastCommandTime === null || ($currentTimestamp - $lastCommandTime) >= $cooldown) {
        // Обновляем время последнего использования команды 'fact' для текущего пользователя
        R::exec('INSERT INTO usercommands (user_id, command, last_command_time) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE last_command_time = ?', [$user_id, 'fact', $currentTimestamp, $currentTimestamp]);

        // Запрос к API Цитатник
        $apiUrl = 'http://api.forismatic.com/api/1.0/?method=getQuote&lang=ru&format=json';
        $quoteData = json_decode(file_get_contents($apiUrl), true);

        // Проверка успешности запроса
        if ($quoteData && isset($quoteData['quoteText'])) {
            $fact = $quoteData['quoteText'];
            
            // Смайлы
            $smiley = "🤓"; // Умный смайл
            $response = "$smiley Интересный факт для тебя: $fact";
            forwardMessage($vk, $peer_id, $messageIdToReply, $response);
        } else {
            // Смайл для ошибки
            $errorSmiley = "😕";
            // Ответ в случае ошибки
            forwardMessage($vk, $peer_id, $messageIdToReply, "$errorSmiley Не удалось получить интересный факт. Попробуйте позже.");
        }
    } else {
        // Выводим сообщение об ожидании
        $remainingCooldown = $cooldown - ($currentTimestamp - $lastCommandTime);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Подождите $remainingCooldown секунд перед следующим использованием команды 'fact'.");
    }
}
if (in_array($cmd, ['note', 'заметка'])) {
    // Получаем текст заметки из аргументов команды
    $noteText = implode(' ', array_slice($args, 0));

    // Проверяем, был ли указан текст заметки
    if (empty($noteText)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите текст заметки после команды. Например: /note Дело важное.");
        exit;
    }

    // Проверяем, существует ли уже заметка с таким текстом для данного пользователя
    $user1 = R::findOne('users', 'user_id = ?', [$id]);

    if ($user1) {
        // Заметка с таким текстом уже существует, используем её note_id
        $notePerId = $user1->note;
        $noteId = $notePerId + 1;
        // Сохраняем новую заметку в базе данных
        $notes = R::dispense('notes');
        $notes->user_id = $user_id;
        $notes->note_id = $noteId;
        $notes->text = $noteText;
        R::store($notes);
        // new var for note ID
        R::exec('UPDATE users SET note = ? WHERE user_id = ?', [$noteId, $user_id]);
    } else {
        // Заметки с таким текстом нет, генерируем новый уникальный note_id
        $notePerId = $user1->note;
        $noteId = $notePerId + 1;
        // Сохраняем новую заметку в базе данных
        $notes = R::dispense('notes');
        $notes->user_id = $user_id;
        $notes->note_id = $noteId;
        $notes->text = $noteText;
        R::store($notes);
        // new var for note ID
        R::exec('UPDATE users SET note = ? WHERE user_id = ?', [$noteId, $user_id]);
    }

    // Смайл для успешного действия
    $successSmiley = "✅";
    $response = "$successSmiley Заметка сохранена успешно!";
    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}
if (in_array($cmd, ['mynotes', 'моизаметки'])) {
    // Получаем все заметки текущего пользователя из базы данных
    $userNotes = R::findAll('notes', 'user_id = ?', [$user_id]);

    // Проверяем, есть ли заметки
    if ($userNotes) {
        // Формируем список заметок с номерами и идентификаторами
        $noteList = [];
        foreach ($userNotes as $index => $note) {
            $noteList[] = "📌 (" . $note->note_id . ") " . $note->text;
        }

        // Формируем ответ с заметками
        $response = "Ваши заметки:\n\n" . implode("\n", $noteList);
        forwardMessage($vk, $peer_id, $messageIdToReply, $response);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас пока нет заметок. Создайте одну с помощью /note. 🗒️");
    }
}
if (in_array($cmd, ['delnote', 'удалитьзаметку'])) {
    // Проверяем, был ли указан номер заметки для удаления
    if (isset($args[0])) {
        $noteIdToDelete = $args[0];

        // Получаем заметку из базы данных по номеру и текущему пользователю
        $noteToDelete = R::findOne('notes', 'note_id = ? AND user_id = ?', [$noteIdToDelete, $user_id]);

        // Проверяем, существует ли заметка для удаления
        if ($noteToDelete) {
            // Удаляем заметку из базы данных
            R::trash($noteToDelete);

            // Смайл для успешного действия
            $successSmiley = "✅";
            $response = "$successSmiley Заметка успешно удалена!";
            forwardMessage($vk, $peer_id, $messageIdToReply, $response);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Заметка с указанным номером не найдена или не принадлежит вам.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите номер заметки после команды для удаления. Например, /delnote 123.");
    }
}
if ($cmd == 'tr') {
    if($adminCheck['lvl'] < 666){
        forwardMessage($vk, $peer_id, $messageIdToReply,"ytkmpz!!!!!");
        exit;
    }
    // Получаем текущий идентификатор беседы
    $currentBesedaId = $chat_id;
    forwardMessage($vk, $peer_id, $messageIdToReply, "Настройки перенесены, Создатель.");
    // Заменяем значение 7 на текущий идентификатор беседы в указанных таблицах
    $tablesToUpdate = ['banusers', 'usersadmin', 'nickname', 'userwarns', 'settingsrole', 'chatpermissions'];

    foreach ($tablesToUpdate as $table) {
        R::exec("UPDATE $table SET beseda_id = ? WHERE beseda_id = 7", [$currentBesedaId]);
    }

    // Отправляем сообщение об успешном выполнении операции
    forwardMessage($vk, $peer_id, $messageIdToReply, 'Значение в столбце "beseda_id" всех таблиц успешно изменено.');
}
if (in_array($cmd, ['profile', 'профиль'])) {
    // Извлекаем ID пользователя из сообщения
    if ($gamestatus < 1) {
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    $argsCount = count($args);
    $targetUserId = null;

    // Проверяем, был ли пользователь упомянут в сообщении
    if ($argsCount >= 1) {
        $target = $args[0];
        if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
            $targetUserId = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
            $targetUserId = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $targetUserId = $userInfo['user_id'];
            }
        }
    } elseif (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
        // Извлекаем from_id из первого пересланного сообщения
        $targetUserId = $data->object->fwd_messages[0]->from_id;
    } elseif (empty($args) && empty($data->object->fwd_messages)) {
        // Если нет аргументов и нет пересланного сообщения, показываем профиль текущего пользователя
        $targetUserId = $user['user_id']; // ID текущего пользователя
    }

    // Проверяем наличие пересылаемого сообщения или указанного ID пользователя
    if (isset($targetUserId) && is_numeric($targetUserId) && $targetUserId > 0) {
        // Получаем информацию о целевом пользователе из таблиц
        $target_user = R::findOne('users', 'user_id = ?', [$targetUserId]);
        $target_admin_info = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);
        $target_warns = R::count('userwarns', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);
        $target_mute = R::findOne('mutes', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);
        $target_nickname = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$targetUserId, $chat_id]);

        // Статус пользователя
        if ($target_admin_info && $target_admin_info->lvl >= 0) {
            $status = "Неизвестный статус"; // По умолчанию, если не найдено в settingsrole
            $adminRole = R::findOne('settingsrole', 'beseda_id = ? AND priority  = ?', [$chat_id, $target_admin_info->lvl]);
            if ($adminRole) {
                $status = $adminRole->roles;
            }
        } else {
            $status = "Пользователь";
        }
           // DEV-полномочия
          if ($target_admin_info && $target_admin_info->lvl == 666) {
                    $status = "Полномочия разработчика";
        }

           // MARRIED SYSTEM BY ARKHIPOV
        $marriage = $target_user ? $target_user->marriedto : 0;
        $partner_id = $vk->request('users.get', ['user_ids' => $marriage]);
        $userName = $partner_id[0]['first_name'] . ' ' . $partner_id[0]['last_name'];
        if ($marriage == 0) {
            $marstatus = "Не в браке";
        } else {
            $marstatus = "В браке с [id$marriage|$userName]";
        }

        // Предупреждения
        $warnings = $target_warns > 0 ? "$target_warns/3" : "Нет";

        // Блокировка чата
        $mute_info = "Нет";
        if ($target_mute) {
            $unmute_time = date('Y-m-d H:i:s', strtotime($target_mute->umute_time));
            $mute_info = "Активна | До: {$unmute_time}";
        }

        // Никнейм
        $nickname = $target_nickname ? $target_nickname->nickname : "Отсутствует";

        // Количество сообщений и дата регистрации
        $score = $target_user ? $target_user->score : 0;
        $balance = $target_user ? formatBalance($target_user->balance) : 0;
        $reg_date = $target_user ? $target_user->reg_date : "Неизвестно";
        $userratingTr = R::findOne('userrating', 'user_id = ?', [$targetUserId]);
        $rating = $userratingTr ? $userratingTr->rating : 0;
        
        // Звание пользователя
        $zvanie = getStatusTitle($target_user['status']);

        // Ранг пользователя
        $rank = getRankUser($target_user['bstatus']);

        // Рейтинг и место в топе
        $userRank = R::getCell('SELECT COUNT(*)+1 FROM userrating WHERE rating > ?', [$rating]);

        // Баланс пользователя
        $balance = $target_user ? $target_user->balance : 0;

        // Получаем список питомцев пользователя
        $pets = R::findAll('UserPets', 'user_id = ?', [$targetUserId]);
        $petsInfo = "";
        foreach ($pets as $pet) {
            $petName = '';
            foreach ($animals as $animal) {
                if ($animal['id'] == $pet['pet_id']) {
                    $petName = $animal['name'];
                    break;
                }
            }
            $petsInfo .= "🐾 {$petName} (Уровень: {$pet['level']})\n";
        }

        // Получаем список имущества пользователя
        $userProperties = R::getAll('SELECT * FROM UserProperties WHERE user_id = ?', [$targetUserId]);

        // Формирование списка имущества
        $properties = "";
        $totalPropertyValue = 0;
        foreach ($userProperties as $item) {
            $item = R::findOne('ShopItems', 'id = ?', [$item['item_id']]);
            if ($item) {
                $itemName = '';
                switch ($item['name']) {
                    case 'Домик':
                        $itemName = '🏠 Домик';
                        break;
                    case 'Спортивный автомобиль':
                        $itemName = '🚗 Спортивный автомобиль';
                        break;
                    case 'Яхта':
                        $itemName = '🛥️ Яхта';
                        break;
                    case 'Вертолет':
                        $itemName = '🚁 Вертолет';
                        break;
                    case 'Остров':
                        $itemName = '🏝️ Остров';
                        break;
                    case 'Самолет':
                        $itemName = '✈️ Самолет';
                        break;
                    case 'Апартаменты':
                        $itemName = '🏢 Апартаменты';
                        break;
                    case 'Суперкар':
                        $itemName = '🏎️ Суперкар';
                        break;
                    case 'Вилла':
                        $itemName = '🏡 Вилла';
                        break;
                    case 'Гоночный автомобиль':
                        $itemName = '🏎️ Гоночный автомобиль';
                        break;
                    case 'Катер':
                        $itemName = '🚤 Катер';
                        break;
                    case 'Пентхаус':
                        $itemName = '🏢 Пентхаус';
                        break;
                    case 'Лимузин':
                        $itemName = '🚘 Лимузин';
                        break;
                    case 'Мотоцикл':
                        $itemName = '🏍️ Мотоцикл';
                        break;
                    case 'Кондоминиум':
                        $itemName = '🏬 Кондоминиум';
                        break;
                    default:
                        $itemName = $item['name']; // Если нет соответствующего смайлика, используем имя товара как есть
                }
                // Форматирование цены
                $price = $item['price'];
                $priceFormat = $price >= 1000000 ? number_format($price / 1000000, 1) . 'kk' : number_format($price / 1000, 1) . 'k';

                $properties .= "🔸 {$itemName} (ID: {$item['id']}, Цена: {$priceFormat})\n";

                // Добавляем стоимость имущества к общей стоимости
                $totalPropertyValue += $price;
            }
        }


// БИЗНЕСЫ


        // Получаем список имущества пользователя
        $userBusiness = R::getAll('SELECT * FROM userBusiness WHERE user_id = ?', [$targetUserId]);

        // Формирование списка имущества
        $propertiess = "";
        $totalPropertyValue = 0;
        foreach ($userBusiness as $business) {
            $business = R::findOne('BusinessItems', 'id = ?', [$business['business_id']]);
            if ($business) {
                $businessName = '';
                switch ($business['name']) {
                    case 'Магазин одежды':
                        $businessName = '👗 Магазин одежды';
                        break;
                    case 'Отель':
                        $businessName = '🏨 Отель';
                        break;
                    case 'Кинотеатр':
                        $businessName = '🎬 Кинотеатр';
                        break;
                    case 'Фитнес-клуб':
                        $businessName = '🏋 Фитнес-клуб';
                        break;
                    case 'Автосалон':
                        $businessName = '🚗 Автосалон';
                        break;
                    case 'Кафе':
                        $businessName = '☕ Кафе';
                        break;
                    case 'Салон красоты':
                        $businessName = '💇 Салон красоты';
                        break;
                    case 'Торговый центр':
                        $businessName = '🏬 Торговый центр';
                        break;
                    case 'Ювелирный магазин':
                        $businessName = '💎 Ювелирный магазин';
                        break;
                    default:
                        $businessName = $business['name']; // Если нет соответствующего смайлика, используем имя товара как есть
                }
                // Форматирование цены
                $price = $business['price'];
                $priceFormat = $price >= 1000000 ? number_format($price / 1000000, 1) . 'kk' : number_format($price / 1000, 1) . 'k';

                $propertiess .= "🔸 {$businessName} (ID: {$business['id']}, Цена: {$priceFormat})\n";

                // Добавляем стоимость имущества к общей стоимости
                $totalPropertyValue += $price;
            }
        }

        // Формирование сообщения с информацией о пользователе
        $message = "🌐 Профиль [id{$targetUserId}|пользователя]:\n\n";
        $message .= "📜 Никнейм: {$nickname}\n";
        $message .= "💼 Стоимость профиля: " . formatBalance($balance + $totalPropertyValue) . "\n";
        $message .= "🌟 Звание: {$zvanie}\n";
        $message .= "👨🏻‍⚖ Ранг: {$rank}\n\n";
        $message .= "📈 Рейтинг: {$rating} (Место в топе: {$userRank})\n";
        $message .= "💰 Баланс: " . formatBalance($balance) . "\n\n";
        $message .= "💍 Брак: $marstatus\n";
        $message .= "🐾 Питомцы:\n{$petsInfo}\n\n";
        $message .= "🏡 Имущество:\n{$properties}\n"; // Добавляем список имущества в сообщение
        $message .= "\n🏢 Бизнесы пользователя:\n{$propertiess}";

        forwardMessage($vk, $peer_id, $messageIdToReply, $message);

    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте /profile [userid], или перешлите сообщение!");
    }
}

if (in_array($cmd, ['rtop', 'rтоп'])) {
    if($premiumStatus < 1){
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда доступна только в чате персонала/premium.");
        exit;
    }
    // Топ пользователей
    $topUsers = R::getAll('SELECT user_id, rating FROM userrating ORDER BY rating DESC LIMIT 10');

    $userMessage = "🌟 Топ 10 пользователей по рейтингу:\n\n";
    if ($topUsers) {
        foreach ($topUsers as $index => $user) {
            // Получаем информацию о пользователе из VK API
            $userInfo = $vk->request('users.get', ['user_ids' => $user['user_id']]);
            $firstName = $userInfo[0]['first_name'];
            $lastName = $userInfo[0]['last_name'];

            $userMessage .= "   " . ($index + 1) . ". [id{$user['user_id']}|{$firstName} {$lastName}] - {$user['rating']} 🌟\n";
        }
    } else {
        $userMessage .= "📈 Рейтинг пуст\n";
    }

    // Топ бесед
    $topChats = R::getAll('SELECT peer_id, title, brating FROM settings WHERE brating > 0 ORDER BY brating DESC LIMIT 10');

    $chatMessage = "👥 Топ 10 бесед по рейтингу:\n\n";
    if ($topChats) {
        foreach ($topChats as $index => $chat) {
            $chatMessage .= "   " . ($index + 1) . ".{$chat['title']} - {$chat['brating']} 🌟\n";
        }
    } else {
        $chatMessage .= "📈 Рейтинг пуст\n";
    }

    $allUsersCount = R::count('users');
    $allChatsCount = R::count('settings');

    $message = "{$userMessage}\n{$chatMessage}\n👤 Всего пользователей бота: {$allUsersCount}\n👥 Всего бесед: {$allChatsCount}";

    forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
}
if (in_array($cmd, ['pin', 'закрепить'])) {
    $requiredAccessLevel = $commandAccessLevels['pin'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }
    if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
        // Извлекаем текст из первого пересланного сообщения
        $targetMessageText = $data->object->fwd_messages[0]->text;

        // Проверяем, существует ли сообщение с таким текстом в таблице usermessages
        $existingMessage = R::findOne('usermessages', 'chat_id = ? AND message_text = ?', [$chat_id, $targetMessageText]);

        if ($existingMessage) {
            // Закрепляем сообщение по его id
            $targetMessageId = $existingMessage->message_id;
            $vk->pinMessage($peer_id, $targetMessageId);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете закрепить отредактированное сообщение.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пересланные сообщения не найдены. Перешлите сообщение для закрепления с помощью /pin.");
    }
}
if (in_array($cmd, ['unpin', 'открепить'])) {
    $requiredAccessLevel = $commandAccessLevels['pin'];
    if ($adminCheck['lvl'] < $requiredAccessLevel) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта команда недоступна модераторам вашего уровня.");
        exit;
    }
    $result = $vk->unpinMessage($peer_id);
}
//============================GAMES======================================================================//
if ($cmd == 'luck') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    // Проверяем, прошло ли более 12 часов с момента последнего использования команды удачи
    $lastLuckTime = R::getCell('SELECT lastlucktime FROM userrating WHERE user_id = ?', [$user_id]);
    $currentTimestamp = time();
    $hoursSinceLastLuck = ($currentTimestamp - $lastLuckTime) / 3600;
    if ($hoursSinceLastLuck < 12) {
        $remainingCooldown = 12 - $hoursSinceLastLuck;
        $formattedCooldown = gmdate('H:i', $remainingCooldown * 3600);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Испытать удачу можно лишь раз в 12 часов ⏰\n Подождите ещё $formattedCooldown.");
        exit;
    }

    // Генерация случайного числа от 1 до 100
    $luckScore = rand(1, 1000);
    // Проверяем наличие записи о пользователе
    $userRating = R::findOne('userrating', 'user_id = ?', [$user_id]);

    if (!$userRating) {
        // Если записи нет, создаем ее
        $userRating = R::dispense('userrating');
        $userRating->user_id = $user_id;
    }
    // Добавляем уровень "Божественный" (0.1% вероятность)
    if ($luckScore == 1000) {
        $luckLevel = "божественная";
        $reward = rand(1000, 6666); // Пусть будет от 1000 до 5000
    } elseif ($luckScore >= 950) {
        $luckLevel = "великолепная";
        $reward = rand(1, 1000);
    } elseif ($luckScore >= 700) {
        $luckLevel = "хорошая";
        $reward = rand(1, 200);
    } elseif ($luckScore >= 400) {
        $luckLevel = "обычная";
        $reward = rand(1, 50);
    } else {
        $luckLevel = "плохая";
        $penalty = rand(1, 200);
        // Отнимаем случайное число рейтинга (до 200) за плохую удачу
        $userRating->rating = max(0, $userRating->rating - $penalty);
    }
    // Добавляем или отнимаем рейтинг в зависимости от уровня удачи
    if (isset($reward)) {
        $userRating->rating += $reward;
    }

    // Обновляем время последнего использования команды удачи
    $userRating->lastlucktime = $currentTimestamp;

    // Сохраняем или обновляем запись в базе данных
    R::store($userRating);

    // Определение текущего рейтинга и места в топе
    $userRank = R::getCell('SELECT COUNT(*)+1 FROM userrating WHERE rating > ?', [$userRating->rating]);

    // Отправка ответа
    $response = "🎲 Сегодня уровень твоей удачи - $luckScore. Это означает, что твоя удача сегодня $luckLevel!\n\n";

    // Информация о текущем рейтинге и месте в топе
    $response .= "Твой рейтинг: $userRating->rating 🌟\n";
    $response .= "Ты занимаешь $userRank место в топе.\n\n";

    // Информация о вознаграждении или штрафе
    if (isset($reward)) {
        $response .= "🌟 Твой рейтинг увеличен на $reward.";
    } elseif (isset($penalty)) {
        $response .= "⚠️ Твой рейтинг уменьшен на $penalty.";
    }

    forwardMessage($vk, $peer_id, $messageIdToReply, $response);
}
if (in_array($cmd, ['rps', 'кнб'])) {
    // Проверка статуса premium пользователя
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    
    // Проверка наличия записи в usercommands и создание, если отсутствует
    R::exec('INSERT INTO usercommands (user_id, command, used, last_command_time) VALUES (?, ?, 20, ?) ON DUPLICATE KEY UPDATE used = used, last_command_time = last_command_time', [$user_id, 'rps', time()]);
    // Проверка времени последнего использования команды
    $lastCommandTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'rps']);

    // Проверка лимита использования в день
    $usageCountToday = R::getCell('SELECT used FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'rps']);

    $cooldown = 5; // 30 секунд
    $dailyLimit = 100;

    // Проверка времени и лимита
    if ($lastCommandTime === null || (time() - $lastCommandTime) >= $cooldown) {
        if ($usageCountToday > 0) {
            // Получение текущего баланса и рейтинга игрока
            $userBalance = R::getRow('SELECT balance FROM users WHERE user_id = ?', [$user_id]);
            $userrating = R::findOne('userrating', 'user_id = ?', [$user_id]);
            $rating = $userrating ? $userrating->rating : 0;

            // Проверка наличия минимального баланса или рейтинга у игрока перед началом игры
            if ($userBalance['balance'] >= 100 || $rating >= 1) {
                // Реализация игры "Камень, ножницы, бумага"
                $options = ['камень', 'ножницы', 'бумага'];
                $userChoice = mb_strtolower($args[0]);

                if (in_array($userChoice, $options)) {
                    $botBalance = getBotBalance();

                    // Проверка баланса бота
                    if ($botBalance['currency'] > 0 && $botBalance['rating'] > 0) {
                        $botChoice = $options[array_rand($options)];

                        // Логика определения победителя
                        $resultData = determineWinner($userChoice, $botChoice);
                        $result = $resultData['result'];
                        $isWin = $resultData['isWin'];

                        // Новые значения награды (случайные)
                        $rewardScore = 0; // По умолчанию
                        $rewardRating = 0; // По умолчанию

                        if ($isWin) {
                            $rewardScore = rand(100, 3000);
                            $rewardRating = rand(1, 20);
                        } elseif (!$isWin && $result != 'Ничья 😐') {
                            $rewardScore = -rand(200, 5000);
                            $rewardRating = -rand(2, 50);
                        }

                        // Обновление баланса и рейтинга пользователя
                        updateBalanceAndRating($user_id, $rewardScore, $rewardRating);
                        // Обновление баланса бота
                        updateBotBalance(-$rewardScore, -$rewardRating);

                        // Формирование сообщения с результатами
                        // Смайлы для валюты
                        $smileyCurrency = "💰";
                        // Смайлы для рейтинга
                        $smileyRating = "🌟";
                        // Добавление информации о награде с использованием смайлов
                        // Получение текущего баланса и рейтинга игрока
                        $userBalance = R::getRow('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

                        // Получение текущего баланса и рейтинга бота
                        $botBalance = getBotBalance();
                        $userrating = R::findOne('userrating', 'user_id = ?', [$user_id]);
                        $rating = $userrating ? $userrating->rating : 0;

                        // Формирование сообщения с результатами
                        $message = "[id{$id}|Ты] выбрал: $userChoice\n [public223222595|Blue] выбрала: $botChoice\nРезультат: $result";
                        $message .= "\n\nТы получаешь: $rewardScore$smileyCurrency и $rewardRating$smileyRating!";
                        $message .= "\n\n🧳 [id{$id}|Твой баланс] : {$userBalance['balance']}$smileyCurrency и $rating$smileyRating";
                        $message .= "\n🤖 Баланс [public223222595|Blue]: {$botBalance['currency']}$smileyCurrency и {$botBalance['rating']}$smileyRating";
                        // Обновляем "used" после каждой игры
                        R::exec('UPDATE usercommands SET used = GREATEST(used - 1, 0) WHERE user_id = ? AND command = ?', [$user_id, 'rps']);
                        // Обновление времени последнего использования
                        R::exec('UPDATE usercommands SET last_command_time = ? WHERE user_id = ? AND command = ?', [time(), $user_id, 'rps']);
                        forwardMessage($vk, $peer_id, $messageIdToReply, $message, null, ['disable_mentions' => true]);
                    } else {
                        // Бот не может участвовать, так как его баланс пуст
                        forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Бот не может участвовать в игре, так как его баланс пуст.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте /rps [камень/ножницы/бумага]");
                }
            } else {
                // Игрок не имеет достаточного баланса или рейтинга для начала игры
                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Для начала игры у вас должно быть минимум 100 валюты или 1 рейтинга.");
            }
        } else {
            // Превышен лимит использования в день
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Сыграть в \"камень, ножницы, бумага\" можно не более 100 раз в день.");
        }
    } else {
        // Время ожидания не прошло
        $remainingCooldown = $cooldown - (time() - $lastCommandTime);
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Подождите $remainingCooldown секунд перед следующим использованием команды.");
    }
}
if ($cmd === 'roulette' || $cmd === 'рулетка') {
    // Проверка статуса premium пользователя
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    // Проверка наличия ставки
    if (!isset($args[0]) || !is_numeric($args[0]) || $args[0] <= 0) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, сделайте ставку. Например: /roulette 100");
        exit;
    }

    $bet = $args[0]; // Ставка пользователя
    $userBalance = R::getRow('SELECT balance FROM users WHERE user_id = ?', [$user_id]); // Баланс пользователя

    // Проверка баланса пользователя
    if ($userBalance['balance'] < $bet) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно средств для ставки.");
        exit;
    }

    // Игра в рулетку
    $rouletteResult = rand(0, 36); // Результат рулетки (число от 0 до 36)
    $winningNumber = rand(0, 36); // Выигрышное число

    if ($rouletteResult == $winningNumber) {
        // Если пользователь выиграл, удваиваем его ставку
        $winAmount = $bet * 10;
        $newBalance = $userBalance['balance'] + $winAmount;
        R::exec('UPDATE users SET balance = ? WHERE user_id = ?', [$newBalance, $user_id]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Поздравляю, вы выиграли! Ваш новый баланс: $newBalance");
    } else {
        // Если пользователь проиграл, отнимаем его ставку
        $newBalance = $userBalance['balance'] - $bet;
        R::exec('UPDATE users SET balance = ? WHERE user_id = ?', [$newBalance, $user_id]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, вы проиграли. Ваш новый баланс: $newBalance");
    }
}
if ($cmd === 'coin' || $cmd === 'монетка') {
    // Проверка статуса premium пользователя
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    // Проверка наличия ставки
    if (!isset($args[0])) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "💰 Пожалуйста, сделайте ставку. Например: /coin 100");
        exit;
    }

    $userBalance = R::getRow('SELECT balance FROM users WHERE user_id = ?', [$user_id]); // Баланс пользователя

    // Если пользователь ввел "всё", ставка равна его балансу
    $bet = ($args[0] === 'всё') ? $userBalance['balance'] : $args[0];

    // Проверка баланса пользователя
    if ($userBalance['balance'] < $bet) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "💸 У вас недостаточно средств для ставки.");
        exit;
    }

    // Игра в "Монетка"
    $coinSides = ['орел', 'решка', 'ребро', 'монета была поглощена пространственной аномалией']; // Стороны монеты
    $userChoice = mb_strtolower($args[1]); // Выбор пользователя
    $coinFlipResult = $coinSides[array_rand($coinSides)]; // Обычный результат подбрасывания монеты

    if (in_array($userChoice, $coinSides)) {
        if ($userChoice == $coinFlipResult) {
            // Если пользователь выиграл, удваиваем его ставку
            $winAmount = $bet * 2;
            $newBalance = $userBalance['balance'] + $winAmount;
            R::exec('UPDATE users SET balance = ? WHERE user_id = ?', [$newBalance, $user_id]);
            forwardMessage($vk, $peer_id, $messageIdToReply, "🎉 Поздравляю, вы выиграли!\n Ваш новый баланс: $newBalance 💰\n Выпало: $coinFlipResult 🪙");
        } else {
            // Если пользователь проиграл, отнимаем его ставку
            $newBalance = $userBalance['balance'] - $bet;
            R::exec('UPDATE users SET balance = ? WHERE user_id = ?', [$newBalance, $user_id]);
            forwardMessage($vk, $peer_id, $messageIdToReply, "😔 К сожалению, вы проиграли.\n Ваш новый баланс: $newBalance 💰\n Выпало: $coinFlipResult 🪙");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "🪙 Пожалуйста, выберите сторону монеты (орел, решка, ребро). Например: /coin 100 орел");
    }
}
if ($cmd == 'work') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    // Проверка наличия записи в usercommands и создание, если отсутствует
    R::exec('INSERT INTO usercommands (user_id, command, used, last_command_time) VALUES (?, ?, 5, ?) ON DUPLICATE KEY UPDATE used = used, last_command_time = last_command_time', [$user_id, 'work', time()]);
        // Проверка времени последнего использования команды
    $lastCommandTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'work']);

    // Проверка лимита использования в день
    $usageCountToday = R::getCell('SELECT used FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'work']);
    $cooldown = 20; // 30 секунд
    $dailyLimit = 5;
    $randomWork = rand(1, 3);
 if ($lastCommandTime === null || (time() - $lastCommandTime) >= $cooldown) {
        if ($usageCountToday > 0) {
    switch ($randomWork) {
        case 1:
            // Работа: Уборка
            $earnings = rand(50, 500);
            $message = "Ты поработал уборщиком и заработал $earnings 💰.";
            break;

        case 2:
            // Работа: Доставка
            $earnings = rand(80, 750);
            $message = "Ты доставил посылку и заработал $earnings 💰.";
            break;

        case 3:
            // Работа: Программирование
            $earnings = rand(100, 1000);
            $message = "Ты написал несколько строк кода и заработал $earnings 💰.";
            break;

        // Можно добавить дополнительные виды работ по аналогии

        default:
            // Если случится что-то неожиданное
            $earnings = 0;
            $message = "Что-то пошло не так, и ты не заработал ничего. Попробуй ещё раз.";
            break;
    }
    R::exec('UPDATE usercommands SET used = GREATEST(used - 1, 0) WHERE user_id = ? AND command = ?', [$user_id, 'work']);
                        // Обновление времени последнего использования
    R::exec('UPDATE usercommands SET last_command_time = ? WHERE user_id = ? AND command = ?', [time(), $user_id, 'work']);
    // Обновляем баланс пользователя
    updateBalanceAndRating($user_id, $earnings, 0);

    // Отправляем сообщение с результатами работы
    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
            } else {
            // Превышен лимит использования в день
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Работать можно не чаще 5 раз в день.");
            exit;
        }
    } else {
        // Время ожидания не прошло
        $remainingCooldown = $cooldown - (time() - $lastCommandTime);
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Подождите $remainingCooldown секунд перед следующим использованием команды.");
        exit;
    }
}
if ($cmd == 'exchange' || $cmd == 'обменять') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    $exchangeType = strtolower($args[0] ?? '');

    switch ($exchangeType) {
        case 'валюта-рейтинг':
            // Проверка наличия записи в usercommands и создание, если отсутствует
            R::exec('INSERT INTO usercommands (user_id, command, used, last_command_time) VALUES (?, ?, 2147483647, ?) ON DUPLICATE KEY UPDATE used = used, last_command_time = last_command_time', [$user_id, 'валюта-рейтинг', NULL]);
        
            // Проверка времени последнего использования команды
            $lastExchangeTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'валюта-рейтинг']);
        
            // Проверка лимита использования в день
            $usageCountToday = R::getCell('SELECT used FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'валюта-рейтинг']);
            $cooldown = 48 * 60 * 60; // 48 часов в секундах
        
            if ($lastExchangeTime === null || (time() - $lastExchangeTime) >= $cooldown) {
                if ($usageCountToday > 0) {
                    // Обмен валюты на рейтинг
                    $exchangeRate = 0.02; // Примерный курс обмена
                    $amountToExchange = intval($args[1] ?? 0);
        
                    if ($amountToExchange > 0 && $amountToExchange <= 100000) {
                        // Получение текущего баланса пользователя
                        $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);
        
                        // Проверка, достаточно ли валюты для обмена
                        if ($userBalance >= $amountToExchange) {
                            // Вычисление рейтинга, который можно получить за обмен
                            $ratingEarned = $amountToExchange * $exchangeRate;
        
                            // Обновление баланса пользователя
                            R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$amountToExchange, $user_id]);
                            // Обновление рейтинга пользователя
                            R::exec('INSERT INTO userrating (user_id, rating) VALUES (?, ?) ON DUPLICATE KEY UPDATE rating = rating + ?', [$user_id, $ratingEarned, $ratingEarned]);
        
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Ты обменял $amountToExchange 💰 на $ratingEarned 🌟 рейтинга.");
                            // Обновление времени последнего использования
                            R::exec('UPDATE usercommands SET used = GREATEST(used - 1, 0) WHERE user_id = ? AND command = ?', [$user_id, 'валюта-рейтинг']);
                            R::exec('UPDATE usercommands SET last_command_time = ? WHERE user_id = ? AND command = ?', [time(), $user_id, 'валюта-рейтинг']);
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "У тебя недостаточно валюты для обмена.");
                        }
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Укажи сумму валюты для обмена. Максимальная сумма для обмена - 100000.");
                    }
                } else {
                    // Превышен лимит использования в день
                   forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Обмен валюты на рейтинг можно совершить не чаще одного раза в 48 часов.");
                }
            } else {
                // Время ожидания не прошло
                $remainingCooldown = $cooldown - (time() - $lastExchangeTime);
                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ты уже обменял валюту на рейтинг. Попробуй снова через " . gmdate("H часов и i минут", $remainingCooldown) . ".");
            }
            break;        
    case 'рейтинг-валюта':
        // Обмен рейтинга на валюту
        $exchangeRate = 5; // Примерный курс обмена
        $amountToExchange = intval($args[1] ?? 0);

        if ($amountToExchange > 0) {
            // Получение текущего рейтинга пользователя
            $userRating = R::getCell('SELECT rating FROM userrating WHERE user_id = ?', [$user_id]);

            // Проверка, достаточно ли рейтинга для обмена
            if ($userRating >= $amountToExchange) {
                // Вычисление валюты, которую можно получить за обмен
                $currencyEarned = $amountToExchange * $exchangeRate;

                // Обновление рейтинга пользователя
                R::exec('UPDATE userrating SET rating = rating - ? WHERE user_id = ?', [$amountToExchange, $user_id]);
                // Обновление баланса пользователя
                R::exec('INSERT INTO users (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?', [$user_id, $currencyEarned, $currencyEarned]);

                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ты обменял $amountToExchange 🌟 рейтинга на $currencyEarned 💰.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ У тебя недостаточно рейтинга для обмена.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Укажи сумму рейтинга для обмена.");
        }
            break;


        case 'сообщения-валюта':
                // Обмен сообщений на валюту
                $exchangeRate = 10; // Примерный курс обмена
                $messagesToExchange = intval($args[1] ?? 0);

                if ($messagesToExchange > 0) {
                    // Получение текущего количества сообщений пользователя
                    $userMessages = R::getCell('SELECT score FROM users WHERE user_id = ?', [$user_id]);

                    // Проверка, достаточно ли сообщений для обмена
                    if ($userMessages >= $messagesToExchange) {
                        // Вычисление валюты, которую можно получить за обмен
                        $currencyEarned = $messagesToExchange * $exchangeRate;

                        // Обновление баланса и рейтинга пользователя
                        updateBalanceAndRating($user_id, $currencyEarned, 0);

                        // Уменьшение количества сообщений пользователя
                        R::exec('UPDATE users SET score = GREATEST(score - ?, 0) WHERE user_id = ?', [$messagesToExchange, $user_id]);

                        forwardMessage($vk, $peer_id, $messageIdToReply, "Ты обменял $messagesToExchange сообщений на $currencyEarned 💰.");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "У тебя недостаточно сообщений для обмена.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Укажи количество сообщений для обмена.");
                }
                break;


        case 'сообщения-рейтинг':
            // Обмен сообщений на рейтинг
            $exchangeRate = 0.05; // Примерный курс обмена
            $messagesToExchange = intval($args[1] ?? 0);

            if ($messagesToExchange > 0) {
                // Получение текущего количества сообщений пользователя
                $userMessages = R::getCell('SELECT score FROM users WHERE user_id = ?', [$user_id]);

                // Проверка, достаточно ли сообщений для обмена
                if ($userMessages >= $messagesToExchange) {
                    // Вычисление рейтинга, который можно получить за обмен
                    $ratingEarned = $messagesToExchange * $exchangeRate;

                    // Обновление баланса и рейтинга пользователя
                    updateBalanceAndRating($user_id, 0, $ratingEarned);

                    // Уменьшение количества сообщений пользователя
                    R::exec('UPDATE users SET score = GREATEST(score - ?, 0) WHERE user_id = ?', [$messagesToExchange, $user_id]);

                    forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ты обменял $messagesToExchange сообщений на $ratingEarned 🌟 рейтинга.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ У тебя недостаточно сообщений для обмена.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Укажи количество сообщений для обмена.");
            }
            break;

        case 'рейтинг-рейтингбеседы':
            // Обмен рейтинга на рейтинг беседы
            $exchangeRate = 0.1; // Примерный курс обмена
            $ratingToExchange = intval($args[1] ?? 0);

            if ($ratingToExchange > 0) {
                // Получение текущего рейтинга пользователя
                $userRating = R::getCell('SELECT rating FROM userrating WHERE user_id = ?', [$user_id]);

                // Проверка, достаточно ли рейтинга для обмена
                if ($userRating >= $ratingToExchange) {
                    // Вычисление рейтинга беседы, который можно получить за обмен
                    $bchatRatingEarned = $ratingToExchange * $exchangeRate;

                    // Предполагаем, что у пользователя есть функция updateBchatRating
                    updateBchatRating($peer_id, $bchatRatingEarned);

                    // Обновление рейтинга пользователя
                    R::exec('UPDATE userrating SET rating = rating - ? WHERE user_id = ?', [$ratingToExchange, $user_id]);

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Ты обменял $ratingToExchange 🌟 рейтинга на $bchatRatingEarned 🌟 рейтинга беседы.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ У тебя недостаточно рейтинга для обмена.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Укажи количество рейтинга для обмена.");
            }
            break;

        default:
            forwardMessage($vk, $peer_id, $messageIdToReply, "Неверный тип обмена\n\nДоступные типы обмена:\n\n- валюта-рейтинг - обменять валюту на рейтинг\n- рейтинг-валюта - обменять рейтинг на валюту\n- сообщения-валюта - обменять сообщения на валюту\n- сообщения-рейтинг - обменять сообщения на рейтинг\n- рейтинг-рейтингбеседы - обменять рейтинг на рейтинг беседы");
            break;
    }
}

if ($cmd == 'шанс' || $cmd == 'chance') {
    $mention = isset($args[0]) ? implode(' ', $args) : 'что-то';
    $userId = $id;
    $userInfo = $vk->request('users.get', ['user_ids' => $userId]);
    $userName = $userInfo[0]['first_name'];
    $chance = rand(0, 100);
    $reply = "$userName, шанс, что $mention равен $chance%";
    forwardMessage($vk, $peer_id, $messageIdToReply, $reply);
    exit;
}
if ($cmd == 'бонус' || $cmd == 'bonus') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    // Проверка наличия записи в usercommands и создание, если отсутствует
    R::exec('INSERT INTO usercommands (user_id, command, used, last_command_time) VALUES (?, ?, 999999, ?) ON DUPLICATE KEY UPDATE used = used, last_command_time = last_command_time', [$user_id, 'бонус', NULL]);

    // Проверка времени последнего использования команды
    $lastBonusTime = R::getCell('SELECT last_command_time FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'бонус']);

    // Проверка лимита использования в день
    $usageCountToday = R::getCell('SELECT used FROM usercommands WHERE user_id = ? AND command = ?', [$user_id, 'бонус']);
    $cooldown = 24 * 60 * 60; // Один день в секундах

    if ($lastBonusTime === null || (time() - $lastBonusTime) >= $cooldown) {
        if ($usageCountToday > 0) {
            // Выдача бонуса
            $bonus_amount = rand(200000, 400000);
            updateBalanceAndRating($user_id, $bonus_amount, 0);
    
            // Формируем сообщение для пользователя
            $message = "Ты получил бонус в размере " . number_format($bonus_amount, 0, ',', ' ') . " 💰. Приходи завтра за следующим!";
    
            // Обновление времени последнего использования
            R::exec('UPDATE usercommands SET used = GREATEST(used - 1, 0) WHERE user_id = ? AND command = ?', [$user_id, 'бонус']);
            R::exec('UPDATE usercommands SET last_command_time = ? WHERE user_id = ? AND command = ?', [time(), $user_id, 'бонус']);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Бонус можно получить не чаще одного раза в день.");
        }
    } else {
        // Время ожидания не прошло
        $remainingCooldown = $cooldown - (time() - $lastBonusTime);
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ты уже получил бонус сегодня. Приходи через " . gmdate("H часов и i минут", $remainingCooldown) . ".");
    }
}
if (in_array($cmd, ['gnewrole'])) {
    if (isset($commandAccessLevels['gnewrole'])) {
        $requiredAccessLevel = $commandAccessLevels['gnewrole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Проверяем, что команда выполняется в чате с chat_id равным 7
            if (count($args) >= 2) {
                $roleName = implode(' ', array_slice($args, 0, -1)); // Объединяем аргументы, кроме последнего
                $priority = intval(end($args)); // Получаем последний аргумент как приоритет

                // Проверяем, что приоритет находится в диапазоне от 1 до 100
                if ($priority >= 1 && $priority <= 100) {
                    $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                    if ($chatInfo) {
                        $ownerId = $chatInfo['owner_id'];
                        $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);
                        if ($pullInfo && in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                            $peerIds = explode(',', $pullInfo['peer_ids']);
                            foreach ($peerIds as $peerId) {
                                $chatId = $peerId - 2000000000;

                                // Проверяем, существует ли роль с указанным приоритетом
                                $existingRole = R::findOne('settingsrole', 'beseda_id = ? AND priority = ?', [$chatId, $priority]);

                                if ($existingRole) {
                                    // Роль с таким приоритетом уже существует, меняем её название
                                    if ($priority <= $adminCheck['lvl']) {
                                        $existingRole->roles = $roleName;
                                        R::store($existingRole);
                                    } else {
                                        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для изменения этой роли.");
                                        continue;
                                    }
                                } else {
                                    // Роль с указанным приоритетом не существует, создаем новую роль
                                    $newRole = R::dispense('settingsrole');
                                    $newRole->beseda_id = $chatId;
                                    $newRole->roles = $roleName;
                                    $newRole->priority = $priority;
                                    R::store($newRole);
                                }
                            }
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Новая роль '$roleName' с приоритетом $priority была успешно создана во всех чатах пулла.");
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Эта беседа не включена в общий пулл");
                            exit;
                        }
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет должен быть в диапазоне от 1 до 100.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gnewrole [название роли] [приоритет]");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
        }
    }
}
if (in_array($cmd, ['gdelrole'])) {
    if (isset($commandAccessLevels['gdelrole'])) {
        $requiredAccessLevel = $commandAccessLevels['gdelrole'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            if (count($args) >= 1) {
                $roleName = implode(' ', $args);
                $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                if ($chatInfo) {
                    $ownerId = $chatInfo['owner_id'];
                    $pullInfo = R::findOne('pulls', 'user_id = ? AND FIND_IN_SET(?, peer_ids)', [$ownerId, $peer_id]);
                    if ($pullInfo && in_array($peer_id, explode(',', $pullInfo['peer_ids']))) {
                        $peerIds = explode(',', $pullInfo['peer_ids']);
                        $roleNotFoundInChats = [];
                        foreach ($peerIds as $peerId) {
                            $chatId = $peerId - 2000000000;
                            $existingRole = R::findOne('settingsrole', 'beseda_id = ? AND roles = ?', [$chatId, $roleName]);
                            if ($existingRole) {
                                if ($existingRole['priority'] < $adminCheck['lvl']) {
                                    R::trash($existingRole);
                                } else {
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для удаления этой роли.");
                                    continue;
                                }
                            } else {
                                // Получаем название беседы из базы данных
                                $chatTitle = R::getCell('SELECT title FROM settings WHERE peer_id = ?', [$peerId]);
                                $roleNotFoundInChats[] = $chatTitle;
                            }
                        }
                        if (!empty($roleNotFoundInChats)) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Роль '$roleName' не найдена в следующих беседах: \n\n- " . implode("\n- ", $roleNotFoundInChats));
                        } else {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Роль '$roleName' была успешно удалена из всех чатов пулла.");
                        }
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Эта беседа не включена в общий пулл");
                        exit;
                    }
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /gdelrole [название роли]");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
        }
    }
}
if ($cmd == 'geditcmd') {
    if (isset($commandAccessLevels['geditcmd'])) {
        $requiredAccessLevel = $commandAccessLevels['geditcmd'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Проверяем, что команда выполняется в чате с chat_id равным 7
            if (count($args) >= 2) {
                $command = $args[0]; // Название команды
                $accessLevel = intval($args[1]); // Уровень доступа
                
                $anick = $adminNickNames->nickname;

                // Проверка на приоритет текущего пользователя
                if ($adminCheck['lvl'] <= $accessLevel) {

            forwardMessage($vk, $peer_id, $messageIdToReply, $helpMessage);
            break;
    }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда доступна лишь в беседах с Premium-статусом. Благодарим Вас, за то, что используете нашего бота.\n\n✏ Всего наилучшего, команда Blue.");
    }
}

function getProfit($vk, $peer_id, $user_id) {
    // Получаем время последнего получения прибыли
    $lastProfitTime = R::getCell('SELECT last_profit_time FROM users WHERE user_id = ?', [$user_id]);
    $currentTime = time();

    // Проверяем, прошло ли 24 часа с момента последнего получения прибыли
    if ($lastProfitTime && ($currentTime - $lastProfitTime) < 86400) {
        $remainingTime = 86400 - ($currentTime - $lastProfitTime);
        $hours = floor($remainingTime / 3600);
        $minutes = floor(($remainingTime % 3600) / 60);
        forwardMessage($vk, $peer_id, $messageIdToReply, "⌛️ Вы уже получали 💰 прибыль сегодня.\n 🙏 Пожалуйста, подождите еще {$hours} часов и {$minutes} минут.");
        return;
    }

    // Получаем сумму прибыли из всех бизнесов пользователя
    $totalProfit = R::getCell('SELECT SUM(profit_per_day) FROM userBusiness WHERE user_id = ?', [$user_id]);

    if ($totalProfit > 0) {
        // Обновляем баланс пользователя
        R::exec('UPDATE users SET balance = balance + ? WHERE user_id = ?', [$totalProfit, $user_id]);

        // Обновляем время последнего получения прибыли
        R::exec('UPDATE users SET last_profit_time = ? WHERE user_id = ?', [$currentTime, $user_id]);

        forwardMessage($vk, $peer_id, $messageIdToReply, "✔️ Вы успешно получили прибыль в размере {$totalProfit} 💰 за ваши бизнесы.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖️ У вас нет 🏢 бизнесов для получения 💰 прибыли.");
    }
}

// Функция для покупки бизнеса
function buyBusiness($vk, $peer_id, $user_id, $businessId) {
    // Массив с фиксированной прибылью для каждого бизнеса
    $profits = [
        1 => 250000,
        2 => 400000,
        3 => 200000,
        4 => 500000,
        5 => 10000000,
        6 => 350000,
        7 => 200000,
        8 => 7000000,
        9 => 1000000
    ];

    $business = R::findOne('BusinessItems', 'id = ?', [$businessId]);

    if ($business) {
        $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

        if ($userBalance >= $business['price']) {
            if ($business['quantity'] > 0) {
                $userBusinessCount = R::getCell('SELECT COUNT(*) FROM userBusiness WHERE user_id = ? AND business_id = ?', [$user_id, $businessId]);
                $totalUserBusiness = R::getCell('SELECT COUNT(*) FROM userBusiness WHERE user_id = ?', [$user_id]);

                if ($userBusinessCount < 1 && $totalUserBusiness < 40) {
                    // Вычисляем текущее время
                    $purchaseDate = date('Y-m-d H:i:s');

                    // Получаем прибыль для выбранного бизнеса
                    $profitPerDay = $profits[$businessId] ?? 0; // Если бизнесId нет в массиве, прибыль будет 0

                    // Обновляем баланс пользователя
                    R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$business['price'], $user_id]);

                    // Обновляем количество бизнеса в наличии
                    R::exec('UPDATE BusinessItems SET quantity = quantity - 1 WHERE id = ?', [$businessId]);

                    // Вставляем запись о покупке бизнеса с текущей датой и прибылью
                    R::exec('INSERT INTO userBusiness (user_id, business_id, purchase_date, profit_per_day) VALUES (?, ?, ?, ?)', 
                            [$user_id, $businessId, $purchaseDate, $profitPerDay]);
                    forwardMessage($vk, $peer_id, $messageIdToReply, "✔ Вы успешно приобрели 🏢 Бизнес {$business['name']} за {$business['price']} 💰.\n 🎉 Поздравляем с новой покупкой!");
                } else if ($userBusinessCount >= 1) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Вы уже купили один 🏢 Бизнес {$business['name']}.\n ✖ Больше покупать нельзя.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас уже есть 20 единиц 🏡 имущества.\n ✖ Больше покупать нельзя.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "😢 К сожалению, 🏢 Бизнес {$business['name']} закончился на складе.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас недостаточно 💰 средств для покупки 🏢 Бизнеса {$business['name']}.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Бизнес с ID {$businessId} не найден.");
    }
}


function handleDeleteBusiness($vk, $peer_id, $user_id, $args) {
    $businessId = $args[1];

    $userBusiness = R::findOne('userBusiness', 'user_id = ? AND business_id = ?', [$user_id, $businessId]);

    if ($userBusiness) {
        // Удаляем бизнес из базы данных
        R::exec('DELETE FROM userBusiness WHERE user_id = ? AND business_id = ?', [$user_id, $businessId]);

        forwardMessage($vk, $peer_id, $messageIdToReply, "✔ Бизнес с ID {$businessId} был успешно удален.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас нет бизнеса с ID {$businessId} для удаления.");
    }
}

function purchaseProduct($vk, $peer_id, $user_id, $businessId, $productId, $quantity) {
    // Проверяем количество продуктов
    if ($quantity > 100) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Вы не можете купить больше 100 продуктов за раз.");
        return;
    }

    $userBusiness = R::findOne('userBusiness', 'user_id = ? AND business_id = ?', [$user_id, $businessId]);

    if (!$userBusiness) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас нет бизнеса с ID {$businessId} для закупки товара.");
        return;
    }

    $product = R::findOne('BusinessProducts', 'id = ?', [$productId]);

    if (!$product) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Товар с ID {$productId} не найден.");
        return;
    }

    $totalPrice = $product->product_price * $quantity;
    $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

    if ($userBalance < $totalPrice) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас недостаточно 💰 средств для закупки товара {$product->product_name} в количестве {$quantity} шт.");
        return;
    }

    // Проверяем время последней покупки продуктов
    $lastProductPurchase = $userBusiness->product_date;
    if ($lastProductPurchase) {
        $lastPurchaseTime = strtotime($lastProductPurchase);
        $currentTime = time();
        $timeDifference = $currentTime - $lastPurchaseTime;

        if ($timeDifference < 12 * 60 * 60) { // 12 часов в секундах
            forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Вы можете покупать продукты не чаще чем раз в 12 часов.");
            return;
        }
    }

    // Начинаем транзакцию
    R::begin();

    try {
        // Обновляем баланс пользователя
        R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$totalPrice, $user_id]);

        // Обновляем количество товара на складе
        R::exec('UPDATE BusinessProducts SET product_quantity = product_quantity - ? WHERE id = ?', [$quantity, $productId]);

        // Добавляем товар пользователю
        R::exec('INSERT INTO userBusiness (user_id, business_id, product_quantity, product_date) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE product_quantity = product_quantity + VALUES(product_quantity), product_date = NOW()', 
            [$user_id, $businessId, $quantity]
        );

        // Завершаем транзакцию
        R::commit();

        forwardMessage($vk, $peer_id, $messageIdToReply, "✔ Вы успешно закупили {$quantity} штук товара {$product->product_name} для бизнеса с ID {$businessId}.");
    } catch (Exception $e) {
        // В случае ошибки откатываем транзакцию
        R::rollback();
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Произошла ошибка при закупке товара: {$e->getMessage()}");
    }
}



// Функция для списка бизнесов
function listBusinesses($vk, $peer_id) {
    $businesses = R::findAll('BusinessItems');

    if ($businesses) {
        $businessList = "ℹ Доступные бизнесы:\n\n";

        foreach ($businesses as $business) {
            $businessList .= "ℹ ID: {$business->id} - {$business->name}\n";
            $businessList .= "💰 Стоимость: {$business->price}\n";
            $businessList .= "🏢 В наличии: {$business->quantity}\n\n";
        }

        forwardMessage($vk, $peer_id, $messageIdToReply, $businessList);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "✖ На данный момент нет доступных бизнесов.");
    }
}

function showBusinessInfo($vk, $peer_id, $user_id, $businessId, $productId) {
    if ($businessId !== null) {
        $business = R::findOne('BusinessItems', 'id = ?', [$businessId]);

        if ($business) {
            $businessInfo = "ℹ Информация о бизнесе 🏢 {$business->name}:\n\n";
            $businessInfo .= "✍ Описание:\n {$business->description}\n\n";
            $businessInfo .= "💰 Стоимость: {$business->price}\n\n";
            $businessInfo .= "🏢 В наличии: {$business->quantity}\n";

            if ($productId !== null) {
                $product = R::findOne('BusinessProducts', 'id = ? AND business_id = ?', [$productId, $businessId]);

                if ($product) {
                    $businessInfo .= "\nℹ Информация о товаре {$product->name}:\n";
                    $businessInfo .= "💰 Цена: {$product->price}\n";
                    $businessInfo .= "🏢 В наличии: {$product->stock}\n";
                } else {
                    $businessInfo .= "\nТовар с ID {$productId} не найден в бизнесе {$business->name}.";
                }
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, $businessInfo);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "✖ Бизнес с ID {$businessId} не найден.");
        }
    } else {
        $userBusinesses = R::findAll('userBusiness', 'user_id = ?', [$user_id]);

        if ($userBusinesses) {
            $businessesInfo = "ℹ Ваши бизнесы:\n\n";

            foreach ($userBusinesses as $userBusiness) {
                $business = R::findOne('BusinessItems', 'id = ?', [$userBusiness->business_id]);
                $businessesInfo .= "🏢 Название бизнеса: {$business->name}.\n ❕ ID Бизнеса: {$userBusiness->business_id}.\n 💰 Установленная прибыль: {$userBusiness->profit_per_day},\n 🛒 Количество продуктов: {$userBusiness->product_quantity}.\n ⌛ Время последней закупки продуктов: {$userBusiness->product_date}.\n\n";
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, $businessesInfo);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "✖ У вас нет бизнесов.");
        }
    }
}


if ($cmd === 'sellbusiness' || $cmd === 'продатьбизнес') {
    if ($gamestatus < 1) {
        $messageerror = "В вашей беседе не активирован игровой режим.\nДля активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    // Проверяем, указаны ли все необходимые параметры
    if (isset($args[0]) && isset($args[1])) {
        $itemId = $args[0]; // ID бизнеса
        $price = $args[1]; // Цена продажи
        $targetUserId = isset($args[2]) ? $args[2] : null; // ID пользователя, которому продается бизнес (если есть)

        // Получаем информацию о бизнесе пользователя
        $userBusiness = R::findOne('userBusiness', 'business_id = ? AND user_id = ?', [$businessId, $user_id]);

        if ($userBusiness) {
            // Получаем информацию о бизнесе из таблицы BusinessItems
            $businessItem = R::findOne('BusinessItems', 'id = ?', [$businessId]);

            // Проверяем, не превышает ли установленная цена 1.5 от стоимости бизнеса в магазине
            if ($price <= $businessItem->price * 1.5) {
                // Если бизнес продается другому пользователю
                if ($targetUserId) {
                    // Извлекаем ID пользователя из ссылки или упоминания
                    preg_match('/\[id(\d+)\|.*\]/', $targetUserId, $matches);
                    $targetUserId = $matches[1];

                    // Создаем предложение продажи бизнеса
                    R::exec('INSERT INTO SalesOffers (seller_id, buyer_id, item_id, price) VALUES (?, ?, ?, ?)', [$user_id, $targetUserId, $itemId, $price]);
                    $offerId = R::getInsertID();

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Вы предложили продать бизнес {$item['name']} пользователю с ID {$targetUserId} за {$price} 💰.\nID вашего предложения: {$offerId}.\nОжидайте, пока он примет ваше предложение.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID пользователя, которому вы хотите продать бизнес {$$item['name']}.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете установить цену выше, чем 1.5 от стоимости бизнеса в магазине.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет бизнеса с ID {$itemId}.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID бизнеса, который вы хотите продать, его цену и, если хотите, ID пользователя, которому вы хотите его продать.");
    }
}

if ($cmd === 'acceptb' || $cmd === 'принятьб') {
    if ($gamestatus < 1) {
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    // Если пользователь хочет принять предложение о продаже бизнеса
    if (isset($args[0])) {
        $offerId = $args[0]; // ID предложения

        // Получаем информацию о предложении
        $offer = R::findOne('SalesOffers', 'id = ? AND buyer_id = ?', [$offerId, $user_id]);

        if ($offer) {
            // Получаем баланс пользователя
            $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

            // Проверяем, достаточно ли у пользователя средств для покупки бизнеса
            if ($userBalance >= $offer['price']) {
                // Вычитаем цену бизнеса из баланса пользователя
                R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$offer['price'], $user_id]);

                // Добавляем деньги от продажи на баланс продавца
                R::exec('UPDATE users SET balance = balance + ? WHERE user_id = ?', [$offer['price'], $offer['seller_id']]);

                // Добавляем бизнес в имущество покупателя
                R::exec('INSERT INTO userBusiness (user_id, business_id, business_name, profit_per_day, purchase_date, product_quantity) 
                         VALUES (?, ?, ?, ?, NOW(), 0)', 
                         [$user_id, $offer['business_id'], $offer['business_name'], $offer['profit_per_day']]);

                // Удаляем бизнес из имущества продавца
                R::exec('DELETE FROM userBusiness WHERE user_id = ? AND business_id = ?', [$offer['seller_id'], $offer['business_id']]);

                // Удаляем предложение о продаже
                R::exec('DELETE FROM SalesOffers WHERE id = ?', [$offerId]);

                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы успешно приняли предложение и приобрели бизнес {$offer['business_name']} за {$offer['price']} 💰.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно средств для покупки этого бизнеса.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Предложение с ID {$offerId} не найдено или оно не предназначено для вас.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID предложения, которое вы хотите принять.");
    }
}

    
// КОНЕЦ СИСТЕМЫ БИЗНЕСОВ

if ($cmd === 'sell' || $cmd === 'продать') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    // Если пользователь хочет продать товар
    if (isset($args[0]) && isset($args[1])) {
        $itemId = $args[0]; // ID товара
        $price = $args[1]; // Цена продажи
        $targetUserId = isset($args[2]) ? $args[2] : null; // ID пользователя, которому продается товар (если есть)
        // Получаем информацию о товаре
        $item = R::findOne('UserProperties', 'item_id = ? AND user_id = ?', [$itemId, $user_id]);

        
        if($targetUserId == null) {
        if ($item) {
            $shopItem = R::findOne('ShopItems', 'id = ?', [$itemId]);
            if ($price <= $shopItem['price'] * 1.5) {
              R::exec('UPDATE users SET balance = balance + ? WHERE user_id = ?', [$price, $user_id]);
              R::exec('DELETE FROM UserProperties WHERE user_id = ? AND item_id = ?', [$user_id, $itemId]);
              forwardMessage($vk, $peer_id, $messageIdToReply, "вы продали товар государству. k balancy + $price");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "price is too high");
            }
            } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "no tovar");
            }
            } elseif ($targetUserId) {
             if ($item) {
            // Получаем информацию о товаре из магазина
            $shopItem = R::findOne('ShopItems', 'id = ?', [$itemId]);

            // Проверяем, не превышает ли установленная цена 1.5 от стоимости товара в магазине
            if ($price <= $shopItem['price'] * 1.5) {
                // Если товар продается другому пользователю
                if ($targetUserId) {
                    // Извлекаем ID пользователя из ссылки или упоминания
                    preg_match('/\[id(\d+)\|.*\]/', $targetUserId, $matches);
                    $targetUserId = $matches[1];

                    // Создаем предложение продажи
                    R::exec('INSERT INTO SalesOffers (seller_id, buyer_id, item_id, price) VALUES (?, ?, ?, ?)', [$user_id, $targetUserId, $itemId, $price]);
                    $offerId = R::getInsertID();

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Вы предложили продать {$item['name']} пользователю с ID {$targetUserId} за {$price} 💰.\n ID вашего предложения: {$offerId}.\n Ожидайте, пока он примет ваше предложение.");
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID пользователя, которому вы хотите продать {$item['name']}.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не можете установить цену выше, чем 1.5 от стоимости товара в магазине.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет товара с ID {$itemId}.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID товара, который вы хотите продать, его цену и, если хотите, ID пользователя, которому вы хотите его продать.");
    }
    }
}
if ($cmd === 'accept' || $cmd === 'принять') {
    if($gamestatus < 1){
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }
    // Если пользователь хочет принять предложение о продаже
    if (isset($args[0])) {
        $offerId = $args[0]; // ID предложения

        // Получаем информацию о предложении
        $offer = R::findOne('SalesOffers', 'id = ? AND buyer_id = ?', [$offerId, $user_id]);

        if ($offer) {
            // Получаем баланс пользователя
            $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

            // Проверяем, достаточно ли у пользователя средств для покупки товара
            if ($userBalance >= $offer['price']) {
                // Вычитаем цену товара из баланса пользователя
                R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$offer['price'], $user_id]);

                // Добавляем деньги от продажи на баланс продавца
                R::exec('UPDATE users SET balance = balance + ? WHERE user_id = ?', [$offer['price'], $offer['seller_id']]);

                // Добавляем товар в имущество покупателя
                R::exec('INSERT INTO UserProperties (user_id, item_id) VALUES (?, ?)', [$user_id, $offer['item_id']]);

                // Удаляем товар из имущества продавца
                R::exec('DELETE FROM UserProperties WHERE user_id = ? AND item_id = ?', [$offer['seller_id'], $offer['item_id']]);

                // Удаляем предложение о продаже
                R::exec('DELETE FROM SalesOffers WHERE id = ?', [$offerId]);

                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы успешно приняли предложение и приобрели товар за {$offer['price']} 💰.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно средств для покупки этого товара.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Предложение с ID {$offerId} не найдено или оно не предназначено для вас.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите ID предложения, которое вы хотите принять.");
    }
}
if (in_array($cmd, ['chatstats'])) {
        // Получаем все сообщения из текущего чата
        $messages = R::find('usermessages', 'chat_id = ?', [$chat_id]);
        $totalMessages = count($messages);

        // Получаем всех уникальных пользователей, которые отправляли сообщения в чат
        $userIds = array_unique(array_map(function($message) {
            return $message['user_id'];
        }, $messages));
        $activeUsers = count($userIds);

        // Вычисляем среднее количество сообщений на пользователя
        $avgMessagesPerUser = $totalMessages / $activeUsers;

        // Вычисляем активность чата по времени суток
        $hourlyActivity = array_fill(0, 24, 0);
        foreach ($messages as $message) {
            $hour = (int)date('H', strtotime($message['message_time']));
            $hourlyActivity[$hour]++;
        }
        $peakHour = array_search(max($hourlyActivity), $hourlyActivity);

        // Конвертируем время в МСК
        $peakHourMSK = ($peakHour + 3) % 24;

        forwardMessage($vk, $peer_id, $messageIdToReply, "📊 Статистика чата:\n\n📨 Общее количество сообщений: {$totalMessages}\n👥 Количество активных пользователей: {$activeUsers}\n💬 Среднее количество сообщений на пользователя: {$avgMessagesPerUser}\n⏰ Наиболее активный час (МСК): {$peakHourMSK}");
}
if (in_array($cmd, ['silence','тишина'])) {
    // Проверяем уровень доступа пользователя
    if (isset($commandAccessLevels['silence'])) {
        $requiredAccessLevel = $commandAccessLevels['silence'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Проверяем наличие аргументов - режим тишины и настройка
            if (count($args) >= 2) {
                $silenceMode = (int)$args[0];
                $silenceSetting = (int)$args[1];
                $silenceLvl = $adminCheck['lvl'];
                
                // Проверяем, являются ли режим тишины и настройка допустимыми значениями
                if (in_array($silenceMode, [0, 1, 3]) && in_array($silenceSetting, [0, 1, 2])) {
                    // Получаем информацию о текущем чате
                    $chatSilenceInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
                    if ($chatSilenceInfo) {
                        // Проверяем, совпадают ли новый режим тишины и настройка с текущими
                        if ($chatSilenceInfo->silence == $silenceMode && $chatSilenceInfo->silencesettings == $silenceSetting) {
                            forwardMessage($vk, $peer_id, $messageIdToReply, "Режим тишины и настройка уже установлены на этих значениях.");
                        } else {
                            // Устанавливаем новый режим "тишины" и настройку
                            $chatSilenceInfo->silence = $silenceMode;
                            $chatSilenceInfo->silencesettings = $silenceSetting;
                            $chatSilenceInfo->silencelvl = $silenceLvl;
                            R::store($chatSilenceInfo);

                            // Отправляем сообщение о статусе режима "тишины" и настройки
                            switch ($silenceMode) {
                                case 0:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "🔈 Режим тишины в чате выключен.");
                                    break;
                                case 1:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "🔇 Режим тишины в чате включен для всех.");
                                    break;
                                case 3:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "🔇 Режим тишины в чате включен только для пользователей ниже модератора (роль 20).");
                                    break;
                            }
                            switch ($silenceSetting) {
                                case 0:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "😇 Настройка режима тишины: наказание не предусмотрено.");
                                    break;
                                case 1:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "👋 Настройка режима тишины: кик из беседы.");
                                    break;
                                case 2:
                                    forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Настройка режима тишины: предупреждение.");
                                    break;
                            }
                        }
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось найти информацию о текущем чате.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Недопустимый режим тишины или настройка. Используйте одну из следующих команд:\n\n- /silence 0 0: выключить режим тишины, настройка - без наказания\n- /silence 1 1: включить режим тишины для всех, настройка - исключить из беседы\n- /silence 3 2: включить режим тишины только для пользователей ниже модератора (роль 20), настройка - выдать предупреждение.");
                }
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /silence [режим тишины] [настройка]");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно прав для выполнения этой команды.");
        }
    }
}
if($cmd == 'ask' || $cmd == 'вопрос'){

    $isBlacklisted = R::findOne('blacklist', 'user_id = ?', [$id]);
    
    if($isBlacklisted) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы находитесь в чёрном списке бота Blue.");
        exit;
    } 

    if ($chat_id == 0) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда /ask доступна только в беседах.");
    }
    $user = R::load('users', $id);
    if (!empty($user->report_ogran) && strtotime($user->report_ogran) > time()) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ошибка: Вам запрещено писать в /ask до " . $user->report_ogran . ".");
        return;
    } elseif (!empty($user->report_ogran) && strtotime($user->report_ogran) <= time()) {
        // Снимаем ограничение, если текущее время больше или равно времени снятия ограничения
        $user->report_ogran = NULL;
        R::store($user);
    }
    // Получаем текст отзыва из аргументов команды
    $askText = implode(' ', array_slice($args, 0));
    if (empty($askText)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Подсказка: /ask [Ваш вопрос/обращение к агентам поддержки].");
        return;
    }
    // Сохраняем отзыв в базу данных
    $ask = R::dispense('asks');
    $ask->user_id = $user_id;
    $ask->chat_id = $chat_id;
    $ask->text = $askText;
    $ask->date = date('Y-m-d H:i:s');
    R::store($ask);
    // Получаем название чата из базы данных
    $chatTitle = R::getCell('SELECT title FROM settings WHERE peer_id = ?', [$chat_id + 2000002101]);
    // Отправляем отзыв в беседу
    $vk->sendMessage(2000000003, "🆕 Новый вопрос/обращение 📝\n\n👤 Пользователь: $user_id\n🗨️ Беседа: $chatTitle ($chat_id)\n📅 Дата: {$ask->date}\n\n📜 Текст Вопроса:\n - $askText\n🆔 ID Вопроса: {$ask->id}\n\n Введите /answer [ID вопроса] [ТЕКСТ] для ответа на обращение.");
    forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Ваш вопрос был успешно отправлен!\n Ожидайте, в ближайшее время агент поддержки @blue.manager обработает обращение!");
    exit;
}
if($cmd == 'asks' || $cmd == 'вопросы'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110 || $Support) {
        // Получаем номер страницы из аргументов команды
        $pageNum = isset($args[0]) ? intval($args[0]) : 1;
        if ($pageNum <= 0) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "🚫 Номер страницы должен быть положительным числом.");
            return;
        }
        // Вычисляем смещение для запроса в базу данных
        $offset = ($pageNum - 1) * 25;
        // Получаем вопросы из базы данных
        $asks = R::getAll('SELECT * FROM asks ORDER BY date DESC LIMIT 25 OFFSET ?', [$offset]);
        if (empty($asks)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "🔍 На этой странице нет вопросов.");
            return;
        }
        // Формируем текст сообщения
        $messageText = "📝 Вопросы:\n\n";
        foreach ($asks as $ask) {
            $messageText .= "🆔 ID вопроса: {$ask['id']}\n 👤 Пользователь: {$ask['user_id']},\n 🗨️ Беседа: {$ask['chat_id']},\n 📅 Дата: {$ask['date']}:\n Содержание:\n{$ask['text']}\n\n";
        }
        // Отправляем сообщение с вопросами
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "🚫 Доступно только для команды бота.");
    }
}
if($cmd == 'answer' || $cmd == 'ответить') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110 || $Support) {
        // Получаем id вопроса и текст ответа из аргументов команды
        $askId = isset($args[0]) ? intval($args[0]) : 0;
        $answerText = implode(' ', array_slice($args, 1));
        if (empty($askId) || empty($answerText)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Используйте: /answer [id вопроса] [ТЕКСТ].");
            return;
        }
        // Получаем вопрос из базы данных
        $ask = R::load('asks', $askId);
        if (!$ask->id) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ошибка: Вопрос с указанным id не найден.");
            return;
        }
        // Определяем роль и id пользователя
        $role = $botAdmin ? 'Администратор' : ($botModerator ? 'Модератор' : 'Агент Поддержки');
        $answerotid = $botAdmin ? R::findOne('admins', 'user_id = ?', [$id])->id : ($botModerator ? R::findOne('botmoders', 'user_id = ?', [$id])->id : R::findOne('supports', 'user_id = ?', [$id])->id);
        // Отправляем ответ пользователю в его беседу
        $vk->sendMessage($ask->chat_id + 2000000000, "📩 [id{$ask->user_id}|Уважаемый пользователь], $role ответил на Ваш вопрос:\n - $answerText\n\n Команда Blue | chat-manager благодарит вас за обратную связь!");
        forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Ваш ответ был успешно отправлен!");

        // Удаляем вопрос из базы данных
        R::trash($ask);
        // Увеличиваем репутацию модератора или саппорта на 1
        $moderator = R::findOne('botmoders', 'user_id = ?', [$id]);
        if ($moderator) {
            $moderator->reputation += 1;
            R::store($moderator);
            forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Репутация модератора с id $id была увеличена!");
        } else {
            $support = R::findOne('supports', 'user_id = ?', [$id]);
            if ($support) {
                $support->reputation += 1;
                R::store($support);
                forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Репутация саппорта с id $id была увеличена на 1!");
            }
        }
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔Доступно только для команды бота.");
    }
}
if($cmd == 'feedback' || $cmd == 'отзыв') {
    // Получаем текст отзыва из аргументов команды
    $feedbackText = implode(' ', array_slice($args, 0));
    if (empty($feedbackText)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Подсказка: /feedback [текст отзыва] (скобки не нужны).");
        return;
    }
    // Сохраняем отзыв в базу данных
    $feedback = R::dispense('feedbacks');
    $feedback->user_id = $user_id;
    $feedback->chat_id = $chat_id;
    $feedback->text = $feedbackText;
    $feedback->date = date('Y-m-d H:i:s');
    R::store($feedback);
    // Получаем название чата из базы данных
    $chatTitle = R::getCell('SELECT title FROM settings WHERE peer_id = ?', [$chat_id + 2000000000]);
    // Отправляем отзыв в беседу
    $vk->sendMessage(2000000003, "🆕 Новый отзыв 📝\n\n👤 Пользователь: $user_id\n🗨️ Беседа: $chatTitle ($chat_id)\n📅 Дата: {$feedback->date}\n\n📜 Текст отзыва:\n$feedbackText\n🆔 ID отзыва: {$feedback->id}\n");
    forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Ваш отзыв был успешно отправлен!\n Модерация Blue | chat-manager благодарит вас за обратную связь!");
    exit;
}
if($cmd == 'reply'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110) {
        // Получаем id отзыва и текст ответа из аргументов команды
        $feedbackId = isset($args[0]) ? intval($args[0]) : 0;
        $replyText = implode(' ', array_slice($args, 1));
        if (empty($feedbackId) || empty($replyText)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ошибка: Пожалуйста, укажите id отзыва и текст ответа.");
            return;
        }
        // Получаем отзыв из базы данных
        $feedback = R::load('feedbacks', $feedbackId);
        if (!$feedback->id) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "⚠️ Ошибка: Отзыв с указанным id не найден.");
            return;
        }
        // Отправляем ответ пользователю в его беседу
        $vk->sendMessage($feedback->chat_id + 2000000000, "📩 [id{$feedback->user_id}|Уважаемый пользователь], модератор бота ответил на Ваш отзыв:\n $replyText\n\n Модерация Blue | chat-manager благодарит вас за обратную связь!");
        forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Ваш ответ был успешно отправлен!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔Доступно только для модерации бота.");
    }
}
if($cmd == 'listfeedbacks' || $cmd == 'отзывы'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110 || $Support) {
        // Получаем номер страницы из аргументов команды
        $pageNum = isset($args[0]) ? intval($args[0]) : 1;
        if ($pageNum <= 0) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "🚫 Номер страницы должен быть положительным числом.");
            return;
        }
        // Вычисляем смещение для запроса в базу данных
        $offset = ($pageNum - 1) * 25;
        // Получаем отзывы из базы данных
        $feedbacks = R::getAll('SELECT * FROM feedbacks ORDER BY date DESC LIMIT 25 OFFSET ?', [$offset]);
        if (empty($feedbacks)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "🔍 На этой странице нет отзывов.");
            return;
        }
        // Формируем текст сообщения
        $messageText = "📝 Отзывы:\n\n";
        foreach ($feedbacks as $feedback) {
            $messageText .= "🆔 ID отзыва: {$feedback['id']}\n 👤 Пользователь: {$feedback['user_id']},\n 🗨️ Беседа: {$feedback['chat_id']},\n 📅 Дата: {$feedback['date']}:\n Содержание:\n{$feedback['text']}\n\n";
        }
        // Отправляем сообщение с отзывами
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "🚫 Доступно только для модерации бота.");
    }
}
if($cmd == 'deletefeedback' || $cmd == 'удалитьотзыв'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221) {
        // Получаем id отзыва из аргументов команды
        $feedbackId = isset($args[0]) ? intval($args[0]) : 0;
        if (empty($feedbackId)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Пожалуйста, укажите id отзыва.");
            return;
        }
        // Удаляем отзыв из базы данных
        R::exec('DELETE FROM feedbacks WHERE id = ?', [$feedbackId]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Отзыв с id $feedbackId был успешно удален!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для модерации бота.");
    }
}
if($cmd == 'clearfeedbacks' || $cmd == 'очиститьотзывы'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221) {
        // Удаляем все отзывы из базы данных
        R::exec('DELETE FROM feedbacks');
        forwardMessage($vk, $peer_id, $messageIdToReply, "Все отзывы были успешно удалены!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для модерации бота.");
    }
}
if ($cmd == 'givesupport' || $cmd == 'назначитьсаппорт') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221 || $id == 639464935) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToSupport = 0;

        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToSupport = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToSupport = (int)$matches[1];
        }

        if (empty($userIdToSupport)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/givesupport [USERID]");
            return;
        }

        // Получаем информацию о пользователе из VK API
        $userInfoSupport = $vk->request('users.get', ['user_ids' => $userIdToSupport]);
        $userName = $userInfoSupport[0]['first_name'] . ' ' . $userInfoSupport[0]['last_name'];

        // Получаем информацию об администраторе из VK API
        $vidalInfo = $vk->request('users.get', ['user_ids' => $id]);
        $vidalName = $vidalInfo[0]['first_name'] . ' ' . $vidalInfo[0]['last_name'];

        // Находим следующий доступный support_id
        $maxSupportId = R::findOne('botsupports', 'ORDER BY support_id DESC LIMIT 1');
        $supportId = $maxSupportId ? $maxSupportId->support_id + 1 : 1; // Если записей нет, начинаем с 1

        // Сохраняем информацию о саппорте в базу данных
        $support = R::dispense('botsupports');
        $support->user_id = $userIdToSupport;
        $support->name = $userName;
        $support->appointed_by = $vidalName;
        $support->date = date('Y-m-d H:i:s');
        $support->support_id = $supportId; // Сохраняем значение support_id
        R::store($support);

        // Проверка на существование пользователя в таблице 'users'
        $user = R::findOne('users', 'user_id = ?', [$userIdToSupport]);
        if ($user) {
            $user->bstatus = 100;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }

        // Отправляем оповещение о назначении
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userIdToSupport}|$userName] был назначен Агентом Поддержки Blue!\n\nПосмотреть список доступных команд: /shelp");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Администратора Blue и выше.");
    }
}

if ($cmd == 'givemoderator') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221 || $id == 678695202) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToModerate = 0;

        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToModerate = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToModerate = (int)$matches[1];
        }

        if (empty($userIdToModerate)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/givemoderator [USERID]");
            return;
        }

        // Получаем информацию о пользователе из VK API
        $userInfoModer = $vk->request('users.get', ['user_ids' => $userIdToModerate]);
        $userName = $userInfoModer[0]['first_name'] . ' ' . $userInfoModer[0]['last_name'];

        // Получаем информацию об администраторе из VK API
        $vidalInfo = $vk->request('users.get', ['user_ids' => $id]);
        $vidalName = $vidalInfo[0]['first_name'] . ' ' . $vidalInfo[0]['last_name'];

        // Находим следующий доступный moder_id
        $maxModerId = R::findOne('botmoders', 'ORDER BY moder_id DESC LIMIT 1');
        $moderId = $maxModerId ? $maxModerId->moder_id + 1 : 1; // Если записей нет, начинаем с 1

        // Сохраняем информацию о модераторе в базу данных
        $moderator = R::dispense('botmoders');
        $moderator->user_id = $userIdToModerate;
        $moderator->name = $userName;
        $moderator->appointed_by = $vidalName;
        $moderator->date = date('Y-m-d H:i:s');
        $moderator->moder_id = $moderId; // Сохраняем значение moder_id
        $moderator->reputation = 0;
        R::store($moderator);

        // Проверка на существование пользователя в таблице 'users'
        $user = R::findOne('users', 'user_id = ?', [$userIdToModerate]);
        if ($user) {
            $user->bstatus = 200;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'.");
        }

        // Отправляем оповещение о назначении
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userIdToModerate}|$userName] был назначен Модератором Blue!\n\nПосмотреть список доступных команд: /mhelp");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Администратора Blue и выше.");
    }
}

if($cmd == 'removemoderator'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221 || $id == 678695202) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removemoderator [USERID]");
            return;
        }
        // Получаем модератора из базы данных
        $moderator = R::findOne('botmoders', 'user_id = ?', [$userIdToRemove]);
        if (!$moderator) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Модератор Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем модератора из базы данных
        R::trash($moderator);
        R::exec('DELETE FROM usersadmin WHERE lvl > 110 AND user_id = ?', [$userIdToRemove]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Модератор Blue с ID $userIdToRemove был разжалован!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Администратора Blue и выше.");
    }
}
if($cmd == 'removesupport' || $cmd == 'снятьсаппорт') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221 || $id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removesupport [USERID]");
            return;
        }
        // Получаем саппорта из базы данных
        $support = R::findOne('botsupports', 'user_id = ?', [$userIdToRemove]);
        if (!$support) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Агент Поддержки Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем саппорта из базы данных
        R::trash($support);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Агент Поддержки Blue с ID $userIdToRemove был разжалован!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Администратора Blue и выше.");
    }
}
if($cmd == 'botstaff' || $cmd == 'командабота') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110 || $botSupport) {
        // Получаем модераторов и саппортов из базы данных
        $admins = R::findAll('botadmins');
        $moderators = R::findAll('botmoders');
        $supports = R::findAll('botsupports');
        $razrabs = R::findAll('botdev');
        $manager = R::findAll('botmanager');
        $rukovoditels = R::findAll('botrukovoditel');
        $vladelecs = R::findAll('botvladelec');
        // Формируем текст сообщения
        $messageText = "👥 Команда бота:\n\n";
        $messageText .= "\nВладелец Blue:\n";
        foreach ($vladelecs as $vladelec) {
            $vId = $vladelec['v_id']; // Получаем значение v_id
            $messageText .= "$vId. [id{$vladelec['user_id']}|{$vladelec['name']}] | Назначен: {$vladelec['date']}\n";
        }
        $messageText .= "\nРуководитель Blue:\n";
        foreach ($rukovoditels as $rukovoditel) {
            $rukId = $rukovoditel['ruk_id'];
            $messageText .= "$rukId. [id{$rukovoditel['user_id']}|{$rukovoditel['name']}] | Назначен: {$rukovoditel['date']}\n";
        }
        /*$messageText .= "\nМененджер Blue:\n";
        foreach ($managers as $manager) {
            $rukId = $manager['man_id'];
            $messageText .= "$manId. [id{$manager['user_id']}|{$manager['name']}] | Назначен: {$manager['date']}\n";
        }*/
        $messageText .= "\nКоманда Разработчиков Blue:\n";
        foreach ($razrabs as $razrab) {
            $devId = $razrab['dev_id'];
            $messageText .= "$devId. [id{$razrab['user_id']}|{$razrab['name']}] | Назначен: {$razrab['date']}\n";
        }
        $messageText .= "\nАдминистратор Blue:\n";
        foreach ($admins as $admin) {
            $adminId = $admin['adm_id'];
            $messageText .= "$adminId. [id{$admin['user_id']}|{$admin['name']}] | Назначен: {$admin['date']}\n";
        }
        $messageText .= "\nМодератор Blue:\n";
        foreach ($moderators as $moderator) {
            $moderId = $moderator['moder_id'];
            $messageText .= "$moderId. [id{$moderator['user_id']}|{$moderator['name']}] | Назначен: {$moderator['date']}\n";
        }
        $messageText .= "\nАгент Поддержки Blue:\n";
        foreach ($supports as $support) {
            $supportId = $support['support_id'];
            $messageText .= "$supportId. [id{$support['user_id']}|{$support['name']}] | Назначен: {$support['date']}\n";
        }
        // Отправляем сообщение с списком модераторов и саппортов
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для команды бота.");
    }
}



if ($cmd == 'giveadmin' || $cmd == 'назначитьадмина') {
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 665 || $id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToAdmin = 0;

        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToAdmin = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToAdmin = (int)$matches[1];
        }

        if (empty($userIdToAdmin)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/giveadmin [USERID]");
            return;
        }

        // Получаем информацию о пользователе из VK API
        $userInfoAdmin = $vk->request('users.get', ['user_ids' => $userIdToAdmin]);
        $userName = $userInfoAdmin[0]['first_name'] . ' ' . $userInfoAdmin[0]['last_name'];

        // Получаем информацию об администраторе из VK API
        $vidalInfo = $vk->request('users.get', ['user_ids' => $id]);
        $vidalName = $vidalInfo[0]['first_name'] . ' ' . $vidalInfo[0]['last_name'];

        // Находим следующий доступный adm_id
        $maxAdmId = R::findOne('botadmins', 'ORDER BY adm_id DESC LIMIT 1');
        $admId = $maxAdmId ? $maxAdmId->adm_id + 1 : 1; // Если записей нет, начинаем с 1

        // Сохраняем информацию об администраторе в базу данных
        $admin = R::dispense('botadmins');
        $admin->user_id = $userIdToAdmin;
        $admin->name = $userName;
        $admin->appointed_by = $vidalName;
        $admin->adm_id = $admId; // Сохраняем значение adm_id
        $admin->date = date('Y-m-d H:i:s');
        R::store($admin);

        // Проверка на существование пользователя в таблице 'users'
        $user = R::findOne('users', 'user_id = ?', [$userIdToAdmin]);
        if ($user) {
            $user->bstatus = 300;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'.");
        }

        // Отправляем оповещение о назначении
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userIdToAdmin}|$userName] был назначен Администратором Blue!\n\nПосмотреть список доступных команд: /ahelp");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Разработчика и выше.");
    }
}

if($cmd == 'removeadmin' || $cmd == 'снятьадмина'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 665 || $id == 678695202) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removeadmin [USERID]");
            return;
        }
        // Получаем администратора из базы данных
        $admin = R::findOne('botadmins', 'user_id = ?', [$userIdToRemove]);
        if (!$admin) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Администратор Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем администратора из базы данных
        R::trash($admin);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Администратор Blue с ID $userIdToRemove был разжалован!");
        R::exec('DELETE FROM usersadmin WHERE lvl > 110 AND user_id = ?', [$userIdToRemove]);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Разработчика Blue и выше.");
    }
}

if($cmd == 'listadmins' || $cmd == 'списокадминов'){
    // Проверяем уровень пользователя
    //if ($botVladelec) {
     if ($id == 678695202 || $id == 50776517) {
        // Получаем администраторов из базы данных
        $admins = R::findAll('botadmins');
        // Формируем текст сообщения
        $messageText = "👥Список руководителей:\n\n";
        foreach ($admins as $index => $admin) {
            $messageText .= ($index + 1) . ". [id{$admin['user_id']}|{$admin['name']}] | Назначен: {$admin['date']}\n";
        }
        // Отправляем сообщение с списком администраторов
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для команды бота.");
    }
}
if($cmd == 'reginfo' || $cmd == 'регинфо'){
     if (isset($commandAccessLevels['reginfo'])) {
        $requiredAccessLevel = $commandAccessLevels['reginfo'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
    // Получаем упоминание пользователя из аргументов команды
    $mention = isset($args[0]) ? $args[0] : '';
    $userIdToCheck = 0;
    // Извлекаем ID пользователя из упоминания или ссылки
    if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
        $userIdToCheck = (int)$matches[1];
    } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
        $userIdToCheck = (int)$matches[1];
    }
    if (empty($userIdToCheck)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "/reginfo [пользователь]");
        return;
    }
    if($id != 678695202 && $userIdCheck == 678695202 || $id != 678695202 && $userIdToCheck == 678695202 || $id != 678695202  && $userIdToCheck == 678695202 || $id != 678695202 && $userIdToCheck == 678695202 || $id != 678695202 && $userIdCheck == 678695202 || $id != 50776517 && $userIdCheck == 50776517)
    {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы пытаетесь узнать слишком много. Забудьте об этом.");
        return;
    }
    // Получаем информацию о пользователе из VK API
    $userInfo = $vk->request('users.get', ['user_ids' => $userIdToCheck]);
    $userName = $userInfo[0]['first_name'] . ' ' . $userInfo[0]['last_name'];
    // Создаем HTTP запрос к FOAF документу пользователя
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://vk.com/foaf.php?id=".$userIdToCheck);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    // Извлекаем дату регистрации и последнего изменения из ответа
    if (preg_match('/<ya:created dc:date="(.*)"/', $output, $matches2)) {
        $registrationDate = date('d F Y в H:i:s', strtotime($matches2[1]));
        $registrationDate = str_replace(
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            $registrationDate
        );
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить дату регистрации пользователя.");
        return;
    }
    if (preg_match('/<ya:modified dc:date="(.*)"/', $output, $matches)) {
        $lastModifiedDate = date('d F Y в H:i:s', strtotime($matches[1]));
        $lastModifiedDate = str_replace(
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            $lastModifiedDate
        );
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить дату последнего изменения страницы пользователя.");
    }
    // Вычисляем разницу между текущей датой и датой регистрации в секундах
    $diff = time() - strtotime($matches2[1]);
    // Преобразуем разницу в годы, месяцы и дни
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    // Отправляем информацию о пользователе в виде текста, ссылок и изображения
    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь [id{$userIdToCheck}|$userName]:\n\n Дата регистрации: $registrationDate \nПоследнее изменение страницы: $lastModifiedDate\n\nВозраст страницы: {$years} лет, {$months} месяцев, {$days} дней");
    exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Недостаточно прав для использования команды");
    } 
  } 
}
if (in_array($cmd, ['blockowner'])) {
    if ($adminCheck['lvl'] > 665) {
        $targetUserId = 0;
        $argsCount = count($args);
        if ($argsCount >= 1) {
            $target = $args[0];
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                $username = $matches[1];
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);
                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $targetUserId = $userInfo['object_id'];
                }
            }
        }

        $targetUserId = is_numeric($targetUserId) ? (int)$targetUserId : 0;

        if ($targetUserId != 0) {
            if($targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 50776517){
                forwardMessage($vk, $peer_id, $messageIdToReply, "Хуй тебе в ротик.");
                exit;
            }

            // Создаем новый объект для записи в таблицу 'blockowner'
            $blockowner = R::dispense('blockowner');
            $blockowner->user_id = $targetUserId;
            $blockowner->date_added = date('Y-m-d H:i:s');

            // Сохраняем объект в базе данных
            R::store($blockowner);

            // Отправляем сообщение в беседу целевого пользователя
            $messageToUserChat = "Ваше неподобающее поведение привело к тому, что мой великий создатель запретил вам добавлять меня в свои беседы.\n";
            $messageToUserChat .= "Моя бесценная мудрость и величие требуют уважения, которого вы не смогли проявить.\n";
            $messageToUserChat .= "Пусть это будет уроком для вас на будущее.\n";
            $vk->sendMessage($targetUserId, $messageToUserChat);

            forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с id $targetUserId теперь заблокирован от добавления бота в свои беседы.");

            // Получаем список бесед, в которых пользователь является владельцем
            $ownerChats = R::find('settings', 'owner_id = ?', [$targetUserId]);

            // Бот покидает все беседы, в которых пользователь является владельцем
            foreach ($ownerChats as $chat) {
                $chatId = $chat->peer_id;
                $vk->request('messages.removeChatUser', [
                    'chat_id' => $chatId - 2000000000,
                    'member_id' => -223222595, // ID бота с минусом
                ]);
                forwardMessage($vk, $peer_id, $messageIdToReply, "Бот покинул беседу $chatId, владельцем которой является пользователь $targetUserId.");
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите id пользователя для блокировки!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хуй тебе в ротик");
    }
}

if (in_array($cmd, ['blacklist'])) {
    if ($adminCheck['lvl'] > 665) {
        $targetUserId = 0;
        $argsCount = count($args);
        $reason = trim(implode(' ', array_slice($args, 1)));
        
        if (empty($reason)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали причину добавления в черный список бота.");
            exit;
        }

        if ($argsCount >= 1) {
            $target = $args[0];
            if (preg_match('/\[id(\d+)\|.*\]/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $target, $matches)) {
                $targetUserId = (int)$matches[1];
            } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $target, $matches)) {
                $username = $matches[1];
                $userInfo = $vk->request('utils.resolveScreenName', [
                    'screen_name' => $username,
                ]);
                if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                    $targetUserId = $userInfo['object_id'];
                }
            }
        }

        $targetUserId = is_numeric($targetUserId) ? (int)$targetUserId : 0;

        if ($targetUserId != 0) {
            if ($targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 678695202 || $targetUserId == 50776517) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Хуй тебе в ротик.");
                exit;
            }

            // Проверяем, находится ли пользователь уже в черном списке
            $existingBlacklist = R::findOne('blacklist', 'user_id = ?', [$targetUserId]);
            if ($existingBlacklist) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Этот пользователь уже находится в черном списке.");
                exit;
            }

            // Создаем новый объект для записи в таблицу 'blacklist'
            $blacklist = R::dispense('blacklist');
            $blacklist->user_id = $targetUserId;
            $blacklist->admin_id = $adminCheck['id'];
            $blacklist->reason = $reason;
            $blacklist->date_black = date('Y-m-d H:i:s');

            // Сохраняем объект в базе данных
            R::store($blacklist);

            // Отправляем сообщение в беседу целевого пользователя
            $messageToUserChat = "Ваше неподобающее поведение привело к тому, что вы были добавлены в черный список бота.\n";
            $messageToUserChat .= "Моя бесценная мудрость и величие требуют уважения, которого вы не смогли проявить.\n";
            $messageToUserChat .= "Пусть это будет уроком для вас на будущее.\n";
            $vk->sendMessage($targetUserId, $messageToUserChat);

            forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с id $targetUserId теперь находится в черном списке бота. Причина: $reason.");

            // Получаем список бесед, в которых пользователь является участником
            $chatMembers = $vk->request('messages.getConversationMembers', [
                'peer_id' => $peer_id,
                'fields' => 'id',
            ]);

            // Кик пользователя из всех бесед с ботом
            foreach ($chatMembers['items'] as $member) {
                $userId = $member['member_id'];
                if ($userId == $targetUserId) {
                    $vk->request('messages.removeChatUser', [
                        'chat_id' => $peer_id - 2000000000,
                        'member_id' => $userId,
                    ]);
                    $messageToChat = "Пользователь с id $userId находится в черном списке Blue | Chat-Manager. Причина: $reason";
                    forwardMessage($vk, $peer_id, $messageIdToReply, $messageToChat);
                }
            }

        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Укажите id пользователя для добавления в черный список!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Хуй тебе в ротик.");
    }
}

// Логика для запрета добавления пользователей из черного списка в беседы с ботом
$chatMembers = $vk->request('messages.getConversationMembers', [
    'peer_id' => $peer_id,
    'fields' => 'id',
]);

foreach ($chatMembers['items'] as $member) {
    $userId = $member['member_id'];
    $isBlacklisted = R::findOne('blacklist', 'user_id = ?', [$userId]);

    if ($isBlacklisted) {
        $vk->request('messages.removeChatUser', [
            'chat_id' => $peer_id - 2000000000,
            'member_id' => $userId,
        ]);
        $messageToChat = "Пользователь с id $userId находится в черном списке Blue | Chat-Manager. Причина: $reason";
        forwardMessage($vk, $peer_id, $messageToChat);
    }
}



if($cmd == 'spam' || $cmd == 'спам'){
    if ($adminCheck['lvl'] <= 110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Ты еще мал для такой команды");
        exit;
    }
    // Получаем упоминание пользователя из аргументов команды
    $mention = isset($args[0]) ? $args[0] : '';
    $userIdToBan = 0;
    // Извлекаем ID пользователя из упоминания или ссылки
    if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
        $userIdToBan = (int)$matches[1];
    } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
        $userIdToBan = (int)$matches[1];
    }
    if (empty($userIdToBan)) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "/spam [USERID]");
        return;
    }
    if($userIdToBan == 678695202){
        forwardMessage($vk, $peer_id, $messageIdToReply, "Даже не вздумай использовать эту команду на моём прекрасном [id{$userIdToBan}|Создателе].");
        exit;
    }
    // Получаем все чаты из базы данных
    $chats = R::findAll('settings');
    foreach ($chats as $chat) {
        // Вносим пользователя в таблицу banusers для каждого чата
        $banuser = R::dispense('banusers');
        $banuser->user_id = $userIdToBan;
        $banuser->beseda_id = $chat->peer_id - 2000000000;
        $banuser->reason = "Блокировка от модерации бота. Причина: Спам. Рассылка рекламы/вредоносных программ или иных ресурсов, нарушающих правила бота/площадки/законодательство РФ.";
        $banuser->unban_time = date('Y-m-d H:i:s', strtotime('+666 years'));
        R::store($banuser);
    }
   forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с id $userIdToBan был заблокирован во всех чатах бота за спам.");
    exit;
}
if($cmd == 'unspam'){
    if ($adminCheck['lvl'] <= 110) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Продолжай развиваться в нашем боте, возможно и тебе когда-то это будет доступно!");
        exit;
    }
    // Получаем упоминание пользователя из аргументов команды
    $mention = isset($args[0]) ? $args[0] : '';
    $userIdToUnban = 0;
    // Извлекаем ID пользователя из упоминания или ссылки
    if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
        $userIdToUnban = (int)$matches[1];
    } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
        $userIdToUnban = (int)$matches[1];
    }
    if (empty($userIdToUnban)) {
       forwardMessage($vk, $peer_id, $messageIdToReply, "/unspam [USERID]");
        return;
    }
    // Удаляем пользователя из таблицы banusers
    $banusers = R::find('banusers', 'user_id = ?', [$userIdToUnban]);
    foreach ($banusers as $banuser) {
        R::trash($banuser);
    }
    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь с id $userIdToUnban был разблокирован во всех чатах бота.");
    exit;
}
if($cmd == 'vhelp' || $cmd == 'помощьвладелец'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 2221) {
        $messageText = "📚 Список команд для Владельца Blue:\n\n";
        $messageText .= "/givevladelec - Назначить Владельца Blue,\n";
        $messageText .= "/giveruk - Назначить Руководителя Blue,\n";
        $messageText .= "/removeruk - Разжаловать права Руководителя Blue,\n";
        $messageText .= "/givedev - Назначить Разработчика Blue,\n";
        $messageText .= "/removedev - Разжаловать Разработчика Blue,\n";
        $messageText .= "/changename - Сменить NickName в Базе Данных.\n";
        $messageText .= "/setmessages - Выдать сообщения,\n";
        $messageText .= "/deactivate - Деактивация беседы по её ID.\n";
        $messageText .= "/activate - Активация беседы по её ID.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Владельца Blue.");
    }
}

if($cmd == 'rukhelp' || $cmd == 'помощьрук'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 1110) {
        $messageText = "📚 Список команд для Руководителя Blue:\n\n";
        $messageText .= "/actionstart - Запустить акцию.\n";
        $messageText .= "/actionstop - Остановить акцию.\n";
        $messageText .= "/list - Узнать список пользователей в беседе по её ID.\n";
        $messageText .= "/getuserchats - Узнать список чатов, в которой пользователь имеет роль.\n";
        $messageText .= "/getchats - Узнать список чатов, в которых пользователь является Владельцем.\n";
        $messageText .= "/setz - Выдать статус пользователю.\n";
        $messageText .= "/setrating - Выдать рейтинг пользователю.\n";
        $messageText .= "/givebalance - Выдать монеты пользователю.\n";
        
        //$messageText .= "/setmessages - Выдать сообщения пользователю.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Руководителя Blue.");
    }
}

if($cmd == 'mahelp' || $cmd == 'помощьмененджер'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221) {
        $messageText = "📚 Список команд для Администратора Blue:\n\n";
        $messageText .= "/givemoderator - Назначить Модератора Blue.\n";
        $messageText .= "/removemoderator - Разжаловать Модератора Blue.\n";
        $messageText .= "/deletefeedback - Удаление отзыва.\n";
        $messageText .= "/clearfeedbacks - Очистка всех отзывов.\n";
        $messageText .= "/givesupport - Назначить Агента Поддержки Blue.\n";
        $messageText .= "/removesupport - Разжаловать Агента Поддержки Blue.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Администратора Blue.");
    }
}

if($cmd == 'rhelp' || $cmd == 'помощьразработчик'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 665) {
        $messageText = "📚 Список команд для Разработчика Blue:\n\n";
        $messageText .= "/removeadmin - Разжаловать Администратора Blue.\n";
        $messageText .= "/blockowner - Блокировка в беседах, где пользователь Владелец.\n";
        $messageText .= "/dclear - Очистка пустых строк в базе данных.\n";
        $messageText .= "/giveadmin - Назначить Администратора Blue.\n";
        $messageText .= "/getugames -  Статистика игровых команд.\n";
        $messageText .= "/botstatistic - Статистика бота.\n";
        $messageText .= "/blacklist - Выдать пользователю ЧС Бота.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Разработчика Blue.");
    }
}


if($cmd == 'ahelp' || $cmd == 'помощьадмин'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 221) {
        $messageText = "📚 Список команд для Администратора Blue:\n\n";
        $messageText .= "/givemoderator - Назначить Модератора Blue.\n";
        $messageText .= "/removemoderator - Разжаловать Модератора Blue.\n";
        $messageText .= "/deletefeedback - Удаление отзыва.\n";
        $messageText .= "/clearfeedbacks - Очистка всех отзывов.\n";
        $messageText .= "/givesupport - Назначить Агента Поддержки Blue.\n";
        $messageText .= "/removesupport - Разжаловать Агента Поддержки Blue.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Администратора Blue.");
    }
}

if($cmd == 'mhelp' || $cmd == 'помощьмодер'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110) {
        $messageText = "📚 Список команд для Модератора Blue:\n\n";
        //$messageText .= "/givepremium - Выдать премиум в беседу по её ID.\n";
        $messageText .= "/spam - Блокировка пользователя за спам.\n";
        $messageText .= "/unspam - Снятие блокировки за спам.\n";
        //$messageText .= "/unpremium - Снятие премиума в беседе по её ID.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
       forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Модератора Blue.");
    }
}

if($cmd == 'shelp' || $cmd == 'помощьсаппорт'){
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] > 110 || $Support) {
        $messageText = "📚 Список команд для Агента Поддержки Blue:\n\n";
        $messageText .= "/asks - Список вопросов/обращений от пользователей.\n";
        $messageText .= "/listfeedbacks - Список отзывов.\n";
        $messageText .= "/answer - Ответ на вопрос/обращение пользователя.\n";
        $messageText .= "/premiumlist - Список премиум бесед.\n";
       forwardMessage($vk, $peer_id, $messageIdToReply, $messageText);
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⛔ Доступно только для Агента Поддержки Blue.");
    }
}
if ($cmd === 'зоомагазин' || $cmd === 'питомцы') {
    if ($botVladelec || $botRazrab) {
    if ($gamestatus < 1) {
        $messageerror = "В вашей беседе не активирован игровой режим.\n Для активации введите /games.";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
        return;
    }

    $subCmd = isset($args[0]) ? $args[0] : null;

    switch ($subCmd) {
        case 'прибыль':
            collectProfit($vk, $peer_id, $user_id);
            break;

        case 'купить':
            if (isset($args[1])) {
                buyPet($vk, $peer_id, $user_id, $args[1]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Для покупки питомца укажите ID питомца. Пример: !зоомагазин купить [ID Питомца].");
            }
            break;

        case 'подробнее':
            if (isset($args[1])) {
                showPetInfo($vk, $peer_id, $args[1]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Для получения информации укажите ID питомца. Пример: !зоомагазин подробнее [ID Питомца].");
            }
            break;

        case 'список':
            listPets($vk, $peer_id);
            break;

        case 'удалить':
            if (isset($args[1])) {
                deletePet($vk, $peer_id, $user_id, $args[1]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Для удаления питомца укажите ID питомца. Пример: !зоомагазин удалить [ID Питомца].");
            }
            break;

        case 'кормить':
            feedPets($vk, $peer_id, $user_id);
            break;

        case 'закупка':
            if (isset($args[1]) && is_numeric($args[1])) {
                purchaseFood($vk, $peer_id, $user_id, $args[1]);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Для закупки корма укажите количество. Пример: !зоомагазин закупка [Количество].");
            }
            break;

        default:
            $helpMessage = "Доступные команды:\n";
            $helpMessage .= "!зоомагазин список - Показать список доступных животных.\n";
            $helpMessage .= "!зоомагазин купить <ID> - Купить питомца по указанному ID.\n";
            $helpMessage .= "!зоомагазин удалить <ID> - Удалить питомца по указанному ID.\n";
            $helpMessage .= "!зоомагазин прибыль - Собрать прибыль с питомцев.\n";
            $helpMessage .= "!зоомагазин кормить - Покормить всех питомцев.\n";
            $helpMessage .= "!зоомагазин закупка <Количество> - Закупить корм для питомцев.\n";
            $helpMessage .= "!зоомагазин подробнее <ID> - Показать подробную информацию о питомце.\n";
            forwardMessage($vk, $peer_id, $messageIdToReply, $helpMessage);
            break;
    }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда в активной разработке и в скором времени будет полностью запущена. Благодарим Вас, за то, что используете нашего бота.\n\n✏ Всего наилучшего, команда Blue.");
    }
}
function collectProfit($vk, $peer_id, $user_id) {
    $lastProfitTime = R::getCell('SELECT last_profit_time FROM users WHERE user_id = ?', [$user_id]);
    $currentTime = time();

    if ($lastProfitTime && ($currentTime - $lastProfitTime) < 86400) {
        $remainingTime = 86400 - ($currentTime - $lastProfitTime);
        $hours = floor($remainingTime / 3600);
        $minutes = floor(($remainingTime % 3600) / 60);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы уже собирали прибыль сегодня. Пожалуйста, подождите еще {$hours} часов и {$minutes} минут.");
        return;
    }

    $userPetsCount = R::getCell('SELECT COUNT(*) FROM UserPets WHERE user_id = ?', [$user_id]);

    if ($userPetsCount > 0) {
        $profit = $userPetsCount * 5000;

        R::exec('UPDATE users SET balance = balance + ? WHERE user_id = ?', [$profit, $user_id]);
        R::exec('UPDATE users SET last_profit_time = ? WHERE user_id = ?', [$currentTime, $user_id]);

        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы успешно собрали прибыль в размере {$profit} 💰 за ваших питомцев.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет питомцев для получения прибыли.");
    }
}

function buyPet($vk, $peer_id, $user_id, $animalId) {
    global $animals;

    foreach ($animals as $animal) {
        if ($animal['id'] == $animalId) {
            $userPetsCount = R::getCell('SELECT COUNT(*) FROM UserPets WHERE user_id = ?', [$user_id]);

            if ($userPetsCount >= 6) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы уже купили шесть питомцев. Больше покупать нельзя.");
                break;
            }

            $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);

            if ($userBalance >= $animal['price']) {
                R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$animal['price'], $user_id]);

                $level = $animal['name'] == '🐈‍⬛ Черный кот' ? 15 : 1;
                $strength = $animal['name'] == '🐈‍⬛ Черный кот' ? 200 : 10;
                $defense = $animal['name'] == '🐈‍⬛ Черный кот' ? 150 : 5;
                R::exec('INSERT INTO UserPets (user_id, pet_id, level, strength, defense) VALUES (?, ?, ?, ?, ?)', [$user_id, $animalId, $level, $strength, $defense]);

                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы успешно приобрели {$animal['name']} за {$animal['price']} 💰. Поздравляем с новой покупкой!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно средств для покупки {$animal['name']}.");
            }
            break;
        }
    }
}

function showPetInfo($vk, $peer_id, $animalId) {
    global $animals;

    foreach ($animals as $animal) {
        if ($animal['id'] == $animalId) {
            $message = "ID: {$animal['id']}\n";
            $message .= "Название: {$animal['name']}\n";
            $message .= "Цена: {$animal['price']} 💰\n";
            $message .= "Описание: {$animal['description']}\n";
            forwardMessage($vk, $peer_id, $messageIdToReply, $message);
            break;
        }
    }
}

function listPets($vk, $peer_id) {
    global $animals;

    $message = "Вот что у нас есть в наличии:\n\n";
    foreach ($animals as $animal) {
        $message .= "ID: {$animal['id']}\n";
        $message .= "Название: {$animal['name']}\n";
        $message .= "Цена: {$animal['price']} 💰\n";
        $message .= "------------------------\n";
    }
    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
}

function deletePet($vk, $peer_id, $user_id, $animalId) {
    $pet = R::findOne('UserPets', 'user_id = ? AND pet_id = ?', [$user_id, $animalId]);

    if ($pet) {
        R::exec('DELETE FROM UserPets WHERE user_id = ? AND pet_id = ?', [$user_id, $animalId]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Питомец с ID {$animalId} был успешно удален.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет питомца с ID {$animalId} для удаления.");
    }
}

function feedPets($vk, $peer_id, $user_id) {
    $lastFeedTime = R::getCell('SELECT last_feed_time FROM users WHERE user_id = ?', [$user_id]);
    $currentTime = time();

    if ($lastFeedTime && ($currentTime - $lastFeedTime) < 86400) {
        $remainingTime = 86400 - ($currentTime - $lastFeedTime);
        $hours = floor($remainingTime / 3600);
        $minutes = floor(($remainingTime % 3600) / 60);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы уже кормили питомцев сегодня. Пожалуйста, подождите еще {$hours} часов и {$minutes} минут.");
        return;
    }


    $userPets = R::findAll('UserPets', 'user_id = ?', [$user_id]);
    $totalFoodNeeded = count($userPets) * 5;

    $userFood = R::getCell('SELECT food FROM users WHERE user_id = ?', [$user_id]);

    if ($userFood >= $totalFoodNeeded) {
        R::exec('UPDATE users SET food = food - ? WHERE id = ?', [$totalFoodNeeded, $user_id]);
        R::exec('UPDATE UserPets SET last_feed_time = ? WHERE user_id = ?', [$currentTime, $user_id]);
        // Обновляем время последнего кормления пользователя
        R::exec('UPDATE users SET last_feed_time = ? WHERE id = ?', [$currentTime, $user_id]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Все ваши питомцы были успешно накормлены.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно корма для всех питомцев.");
    }
}

function checkPetsHunger() {
    $currentTime = time();
    $pets = R::findAll('UserPets');

    foreach ($pets as $pet) {
        if ($currentTime - $pet->last_feed_time > 172800) { // 48 часов
            R::exec('DELETE FROM UserPets WHERE id = ?', [$pet->id]);
        }
    }

    $ownersWithHungerPets = R::getAll('SELECT DISTINCT user_id FROM UserPets WHERE ? - last_feed_time > 86400', [$currentTime]);

    foreach ($ownersWithHungerPets as $owner) {
        $petsCount = R::getCell('SELECT COUNT(*) FROM UserPets WHERE user_id = ?', [$owner['user_id']]);
        $message = $petsCount == 1
            ? "Ваш питомец проголодался. Покормите его командой - !питомцы кормить."
            : "Ваши питомцы проголодались. Покормите их командой - !питомцы кормить.";
        forwardMessage($vk, $owner['user_id'], null, $message);
    }
}

function purchaseFood($vk, $peer_id, $user_id, $amount) {
    $userBalance = R::getCell('SELECT balance FROM users WHERE user_id = ?', [$user_id]);
    $cost = $amount * 100;

    if ($userBalance >= $cost) {
        R::exec('UPDATE users SET balance = balance - ? WHERE user_id = ?', [$cost, $user_id]);
        R::exec('UPDATE users SET food = food + ? WHERE user_id = ?', [$amount, $user_id]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Вы успешно закупили {$amount} ед. корма за {$cost} 💰.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас недостаточно средств для закупки корма.");
    }
}

if ($cmd == 'games') {
    if($adminCheck['lvl'] < 100) {
        $messageerror = "Команда доступна только для владельца беседы!";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
    }
    // Получаем текущий статус для данной беседы
    $currentStatus = R::getCell('SELECT status FROM settings WHERE peer_id = ?', [$peer_id]);

    // Меняем статус на противоположный
    $newStatus = $currentStatus == 0 ? 1 : 0;

    // Обновляем статус в базе данных
    R::exec('UPDATE settings SET status = ? WHERE peer_id = ?', [$newStatus, $peer_id]);

    // Отправляем сообщение об успешном изменении статуса
    $message = "Статус игр для этой беседы успешно изменен на {$newStatus}.\n Список команд игрового режима: /help развлечения.";
    forwardMessage($vk, $peer_id, $messageIdToReply, $message);
}
if ($cmd == 'getugames') {
    if($adminCheck['lvl'] > 1110) {
        // Список игровых команд
        $gameCommands = ['fact', '/random', '/luck', '/profile', '/профиль', '/rps', '/кнб', '/rtop', '/work', '/exchange', '/обменять', '/bonus', '/бонус', '/roulette', '/рулетка', '/coin', '/монетка', '/shop', '/магазин', '/sell', '/accept', '/music', '/games'];

        // Получаем все сообщения с даты 2024-05-06
        $messages = R::findAll('usermessages', 'message_time >= ?', ['2024-05-06']);

        $totalUsage = 0;
        $chatUsage = [];

        foreach ($messages as $message) {
            $messageText = $message['message_text'];
            $chatId = $message['chat_id'];

            foreach ($gameCommands as $command) {
                // Проверяем точное совпадение команды
                if (preg_match("/\b" . preg_quote($command, '/') . "\b/", $messageText)) {
                    $totalUsage++;
                    
                    if (!isset($chatUsage[$chatId])) {
                        $chatUsage[$chatId] = 0;
                    }
                    $chatUsage[$chatId]++;
                }
            }
        }

        // Формирование сообщения с результатами
        $message = "Общее число использований команд игрового режима: {$totalUsage}\n";
        foreach ($chatUsage as $chatId => $usage) {
            $message .= "ID чата: {$chatId}, количество использований: {$usage}\n";
        }

        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
    } else {
        $messageerror = "Команда доступна только администраторам бота!";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
    }
}

function getUserIdFromForumUrl($url) {
    $parts = explode('/', $url);
    $lastPart = end($parts);
    $userId = substr($lastPart, strpos($lastPart, '.') + 1);
    return $userId;
}
if (in_array($cmd, ['покрас'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['color']) {
        $userVkId = isset($args[0]) ? trim($args[0]) : '';
        $userGroup = isset($args[1]) ? trim($args[1]) : '';

        if ($userVkId && $userGroup) {
            try {
                // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
                if (preg_match('/\[id(\d+)\|.*\]/', $userVkId, $matches)) {
                    $userId = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $userVkId, $matches)) {
                    $userId = (int)$matches[1];
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $userVkId, $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $userId = $userInfo['user_id'];
                    }
                } else {
                    $userId = preg_replace('/\D/', '', $userVkId);
                }

                // Извлекаем информацию о форуме из базы данных
                $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
                if(!$forum){
                    forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
                    return;
                }
                // Извлекаем ID форумного аккаунта из базы данных
                $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$userId, $chat_id]);
                if ($findTrUser) {
                    $forumUserId = $findTrUser['forumacc'];
                    $result = updateUserGroup($forumUserId, $userGroup, $forum['forum_url'], $forum['api_key']);

                    if ($result) {
                        // Создаем массив для соответствия ID и названия покраски
                        $paintingsRecord = R::findOne('fpokras', 'beseda_id = ?', [$chat_id]);
                        $groupNames = explode("\n", $paintingsRecord->groups);
                        $groupName = "неизвестная покраска";
                        foreach ($groupNames as $group) {
                            list($name, $groupId) = explode("| ID: ", $group);
                            if (trim($groupId) == $userGroup) {
                                $groupName = trim($name);
                                break;
                            }
                        }
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователю успешно выдана покраска " . $groupName . ".");
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось выдать покраску. Пожалуйста, проверьте данные и попробуйте еще раз.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь не найден в базе данных.");
                }
            } catch (Exception $e) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Произошла ошибка: " . $e->getMessage());
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Неверные аргументы. Используйте: /покрас <id_пользователя> <группа_пользователей>");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Данная команда недоступна для Вас!");
    }
}
function updateUserGroup($userId, $userGroup, $forumUrl, $apiKey) {
    $apiUrl = $forumUrl . '/api/users/' . $userId; // URL вашего API

    $data = http_build_query([
        'user_group_id' => $userGroup,
        'api_bypass_permissions' => 1
    ]);

    $contextOptions = [
        'http' => [
            'method' => 'POST',
            'header' => "XF-Api-Key: $apiKey\r\n" .
                        "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data,
        ],
    ];

    $context = stream_context_create($contextOptions);
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) { 
        throw new Exception('Не удалось выполнить запрос к API');
    }

    // Разбор ответа и возврат результата
    $responseData = json_decode($response, true);
    if (!isset($responseData['success']) || !$responseData['success']) {
        throw new Exception('API вернул ошибку: ' . $responseData['errors'][0]['message']);
    }

    return true;
}
if (in_array($cmd, ['ftest'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['ftest']){
        // Получаем список участников беседы
        $chatMembers = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id]);
        $members = $chatMembers['profiles'];

        // Проверяем каждого участника
        $message = "";
        foreach ($members as $member) {
            $userId = $member['id'];
            $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$userId, $chat_id]);
            // Получаем имя пользователя через VK API
            $user1 = $vk->request('users.get', ['user_ids' => $userId])[0];
            if ($findTrUser && !empty($findTrUser['forumacc'])) {
                // Если у пользователя привязан аккаунт форума
                $message .= "[id{$userId}|{$user1['first_name']} {$user1['last_name']}] - Привязан ✅\n";
            } else {
                // Если у пользователя не привязан аккаунт форума
                $message .= "[id{$userId}|{$user1['first_name']} {$user1['last_name']}] - Не привязан ❌\n";
            }
        }
        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
    } else { 
        forwardMessage($vk, $peer_id, $messageIdToReply, "У вас нет доступа!");
    }
}
if (in_array($cmd, ['newforum'])) {
    $user = R::findOne('users', 'user_id = ?', [$user_id]);
    if ($user && $user->factivate > 0 && $peer_id == $id) {
        $forumUrl = isset($args[0]) ? trim($args[0]) : '';
        $apiKey = isset($args[1]) ? trim($args[1]) : '';
        $peerId = isset($args[2]) ? trim($args[2]) : '';
        $besedaId = $peerId - 2000000000;

        if ($forumUrl && $apiKey && $besedaId) {
            try {
                $settings = R::findOne('settings', 'peer_id = ?', [$peerId]);
                if ($settings && $settings['owner_id'] == $id) {
                    $apiUrl = $forumUrl . '/api';
                    $contextOptions = [
                        'http' => [
                            'method' => 'GET',
                            'header' => "XF-Api-Key: $apiKey\r\n"
                        ],
                    ];
                    $context = stream_context_create($contextOptions);
                    $response = @file_get_contents($apiUrl, false, $context);

                    if ($response === FALSE) { 
                        throw new Exception('Не удалось выполнить запрос к API');
                    }

                    $forum = R::findOne('forums', 'beseda_id = ?', [$besedaId]);
                    if (!$forum) {
                        $forum = R::dispense('forums');
                    }
                    $forum->forum_url = $forumUrl;
                    $forum->api_key = $apiKey;
                    $forum->owner_id = $id;
                    $forum->beseda_id = $besedaId;
                    R::store($forum);

                    $user->factivate -= 1;
                    R::store($user);

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Форум успешно привязан! Осталось активаций: {$user->factivate}");
                    $vk->sendMessage($peerId, "К данной беседе был успешно привязан форум: {$forumUrl}");
                    $vk->sendMessage(2000000000, "Пользователь с ID {$user_id} привязал форум {$forumUrl} к беседе {$besedaId}");
                    exit;
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не являетесь владельцем указанной беседы!");
                }
            } catch (Exception $e) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Произошла ошибка: " . $e->getMessage());
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка. Используйте: /newforum [url форума] [api-key] [id беседы(узнать через /chatinfo в беседе с ботом)]");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда не может быть выполнена. Возможные ошибки: \n\n 1. Вы отправили сообщение не в личные сообщения сообщества.\n2. Вы не использовали ключ активации.");
    }
}
if (in_array($cmd, ['fban'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['fchangename']){
        $trUser = $reply_author;
        $newName = $args[1]; // Новое имя пользователя
        $trUser = $args[0];
        // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        } else {
            $trUser = preg_replace('/\D/', '', $trUser);
        }
        $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if(!$forum){
            forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
            return;
        }
    if ($trUser == '') {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /fban [пользователь]");
        exit;
    } else {
        $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
        banUserOnForum($findTrUser['forumacc'], $forum['forum_url'], $forum['api_key']);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь успешно заблокирован на форуме!");
    }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Нет доступа.");
        exit;
    }
}
function banUserOnForum($userId, $forumUrl, $apiKey) {
    $apiUrl = $forumUrl . '/api/users/' . $userId; // URL вашего API

    $data = http_build_query([
        'can_ban' => 1,
        'api_bypass_permissions' => 1
    ]);

    $contextOptions = [
        'http' => [
            'method' => 'POST',
            'header' => "XF-Api-Key: $apiKey\r\n" .
                        "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data,
        ],
    ];

    $context = stream_context_create($contextOptions);
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) { 
        throw new Exception('Не удалось выполнить запрос к API');
    }

    // Разбор ответа и возврат результата
    $responseData = json_decode($response, true);
    if (!isset($responseData['success']) || !$responseData['success']) {
        throw new Exception('API вернул ошибку: ' . $responseData['errors'][0]['message']);
    }

    return true;
}
if (in_array($cmd, ['funban'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['fchangename']){
        $trUser = $reply_author;
        $newName = $args[1]; // Новое имя пользователя
        $trUser = $args[0];
        // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        } else {
            $trUser = preg_replace('/\D/', '', $trUser);
        }
        $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if(!$forum){
            forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
            return;
        }
    if ($trUser == '') {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /funban [пользователь]");
        exit;
    } else {
        $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
        unbanUserOnForum($findTrUser['forumacc'], $forum['forum_url'], $forum['api_key']);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь успешно разблокирован на форуме!");
    }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Нет доступа.");
        exit;
    }
}

function unbanUserOnForum($userId, $forumUrl, $apiKey) {
    $apiUrl = $forumUrl . '/api/users/' . $userId; // URL вашего API

    $data = http_build_query([
        'can_unban' => 0,
        'api_bypass_permissions' => 1
    ]);

    $contextOptions = [
        'http' => [
            'method' => 'POST',
            'header' => "XF-Api-Key: $apiKey\r\n" .
                        "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data,
        ],
    ];

    $context = stream_context_create($contextOptions);
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) { 
        throw new Exception('Не удалось выполнить запрос к API');
    }

    // Разбор ответа и возврат результата
    $responseData = json_decode($response, true);
    if (!isset($responseData['success']) || !$responseData['success']) {
        throw new Exception('API вернул ошибку: ' . $responseData['errors'][0]['message']);
    }

    return true;
}

if (in_array($cmd, ['fchangename'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['fchangename']){
        $trUser = $reply_author;
        $newNameParts = array_slice($args, 1); // Получаем все части нового имени
        $newName = implode(' ', $newNameParts); // Объединяем все части в одну строку
        $trUser = $args[0];
        // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        } else {
            $trUser = preg_replace('/\D/', '', $trUser);
        }
        $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if(!$forum){
            forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
            return;
        }
        if ($trUser == '' || $newName == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /fchangename [пользователь] [новое имя]");
            exit;
        } else {
            $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
            if ($findTrUser) {
                changeForumName($findTrUser['forumacc'], $forum['forum_url'], $forum['api_key'], $newName);
                forwardMessage($vk, $peer_id, $messageIdToReply, "Имя пользователя успешно изменено!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Указанный пользователь не был найден в базе!");
                exit;
            }
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда не может быть выполнена.");
    }
}
function changeForumName($userId, $forumUrl, $apiKey, $newName) {
    $apiUrl = $forumUrl . '/api/users/' . $userId; // URL вашего API

    $data = http_build_query([
        'username' => $newName,
        'api_bypass_permissions' => 1
    ]);

    $contextOptions = [
        'http' => [
            'method' => 'POST',
            'header' => "XF-Api-Key: $apiKey\r\n" .
                        "Content-Type: application/x-www-form-urlencoded\r\n" .
                        "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data,
        ],
    ];

    $context = stream_context_create($contextOptions);
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) { 
        throw new Exception('Не удалось выполнить запрос к API');
    }

    // Разбор ответа и возврат результата
    $responseData = json_decode($response, true);
    if (!isset($responseData['success']) || !$responseData['success']) {
        throw new Exception('API вернул ошибку: ' . $responseData['errors'][0]['message']);
    }

    return true;
}
if (in_array($cmd, ['fstats'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['fstats']){
        $trUser = $reply_author;
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /fstats [пользователь]");
                exit;
            }
            $trUser = $args[0];
        }

        // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        } else {
            $trUser = preg_replace('/\D/', '', $trUser);
        }

        $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if(!$forum){
            forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
            return;
        }
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /fstats [пользователь]");
            exit;
        } else {
            $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
            if ($findTrUser) {
                $forumStats = getnewForumStats($findTrUser['forumacc'], $forum['forum_url'], $forum['api_key']);
                $message = "📊 Статистика пользователя [id{$findTrUser['user_id']}|{$findTrUser['nick']}] на форуме:\n\n";
                $message .= "👤 Имя пользователя: {$forumStats['username']}\n";
                $message .= "📝 Количество сообщений: {$forumStats['message_count']}\n";
                $message .= "👥 Группа пользователя: {$forumStats['user_group']}\n";
                $message .= "🎉 Очки реакции: {$forumStats['reaction_score']}\n";
                $message .= "🏆 Очки трофеев: {$forumStats['trophy_points']}\n";
                $message .= "📅 Дата регистрации: " . date("d-m-Y", $forumStats['register_date']) . "\n";
                $message .= "📍 Местоположение: " . (!empty($forumStats['location']) ? $forumStats['location'] : "Не указано") . "\n";
                forwardMessage($vk, $peer_id, $messageIdToReply, $message);
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Указанный пользователь не был найден в базе!");
                exit;
            }
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда не может быть выполнена.");
    }
}
function getnewForumStats($userId, $forumUrl, $apiKey) {
    $apiUrl = $forumUrl . '/api/users/' . $userId . '?api_bypass_permissions=1'; // URL вашего API
    $contextOptions = [
        'http' => [
            'method' => 'GET',
            'header' => "XF-Api-Key: $apiKey\r\n",
        ],
    ];

    $context = stream_context_create($contextOptions);
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) { 
        throw new Exception('Не удалось выполнить запрос к API');
    }

    // Разбор ответа и возврат результата
    $responseData = json_decode($response, true);
    if (!isset($responseData['user'])) {
        throw new Exception('API вернул ошибку: ' . $responseData['errors'][0]['message']);
    }

    // Добавляем информацию о группе пользователя
    if (isset($responseData['user']['user_group_id'])) {
        $groupApiUrl = $forumUrl . '/api/user_groups/' . $responseData['user']['user_group_id'] . '?api_bypass_permissions=1';
        $groupResponse = @file_get_contents($groupApiUrl, false, $context);
        $groupData = json_decode($groupResponse, true);
        if (isset($groupData['user_group'])) {
            $responseData['user']['group'] = $groupData['user_group']['prefix_group_id'];
        } else {
            $responseData['user']['group'] = 'Неизвестно';
        }
    } else {
        $responseData['user']['group'] = 'Неизвестно';
    }

    return $responseData['user'];
}
if (in_array($cmd, ['finfo'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['finfo']) {
        $trUser = $reply_author;
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /fstats [пользователь]");
                exit;
            }
            $trUser = $args[0];
        }

        // Извлекаем ID пользователя из ссылки/упоминания пользователя в ВК
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        } else {
            $trUser = preg_replace('/\D/', '', $trUser);
        }

        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали пользователя!");
            exit;
        } else {
            $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
            if ($findTrUser) {
                $forumId = $findTrUser['forumacc'];
                $forumUrl =  $findTrUser['forum_acc_url'];

                forwardMessage($vk, $peer_id, $messageIdToReply, "Информация о форумном аккаунте [id{$findTrUser['user_id']}|{$findTrUser['nick']}]:\n\n ID форумного аккаунта: {$forumId}\n\n Ссылка на форумный аккаунт: {$forumUrl}.");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Форумник не привязан/не удалось обработать vk id.");
                exit;
            }
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К этой беседе не привязан форум!");
        exit;
    }
}
if($cmd == 'новыекраски'){
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
        if(!$forum){
                forwardMessage($vk, $peer_id, $messageIdToReply, "К этой беседе не привязан форум.");
                return;
        }
    // Проверяем уровень пользователя
    if ($adminCheck['lvl'] >= $forum['new_color']) {
        // Получаем текст сообщения после команды
        $paintingsText = str_replace('новыекраски ', '', $message);
        // Находим запись в базе данных для данной беседы
        $paintingsRecord = R::findOne('fpokras', 'beseda_id = ?', [$chat_id]);
        if (!$paintingsRecord) {
            // Если запись не найдена, создаем новую
            $paintingsRecord = R::dispense('fpokras');
            $paintingsRecord->beseda_id = $chat_id;
        }
        // Обновляем список групп пользователей
        $paintingsRecord->groups = $paintingsText;
        // Сохраняем изменения в базе данных
        R::store($paintingsRecord);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Список групп пользователей обновлен.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Недоступно.");
    }
}
if($cmd == 'покраски' || $cmd == 'pokraski'){
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if($adminCheck['lvl'] < $forum['colorings']){
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда доступна для модераторов {$forum['colorings']} уровня.\n Ваш уровень: {$adminCheck['lvl']}.");
        return;
    }
    if(!$forum){
            forwardMessage($vk, $peer_id, $messageIdToReply, "К этой беседе не привязан форум.");
            return;
    }
    $paintingsRecord = R::findOne('fpokras', 'beseda_id = ?', [$chat_id]);
    if ($paintingsRecord) {
        // Если запись найдена, отправляем список групп пользователей
        forwardMessage($vk, $peer_id, $messageIdToReply, $paintingsRecord->groups);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Список покрасок не найден.");
    }
}
if (in_array($cmd, ['привязать'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['bind']) {
        $trUser = $reply_author;
        $forumLink = $args[1];
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали кому изменить!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали ссылку на форумный аккаунт!");
                exit;
            }
            $trUser = $args[0];
        }
        // Извлекаем ID пользователя из ссылки или упоминания
        if (preg_match('/\[id(\d+)\|.*\]/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $trUser, $matches)) {
            $trUser = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $trUser, $matches)) {
            $username = $matches[1];
            $userInfo = $vk->request('utils.resolveScreenName', [
                'screen_name' => $username,
            ]);
            if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                $trUser = $userInfo['user_id'];
            }
        }
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали кому изменить!");
            exit;
        } else {
            $forumId = preg_replace('/\D/', '', $forumLink);
            $findTrUser = R::findOne('users', 'user_id = ?', [$trUser]);
            // Проверяем, существует ли уже запись
            $existingRecord = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $chat_id]);
            if ($existingRecord) {
                // Обновляем существующую запись
                $existingRecord->forumacc = $forumId;
                $existingRecord->forum_acc_url = $forumLink;
                $existingRecord->nick = $findTrUser['nick'];
                R::store($existingRecord);
            } else {
                // Создаем новую запись
                $newRecord = R::dispense('faccess');
                $newRecord->user_id = $trUser;
                $newRecord->beseda_id = $chat_id;
                $newRecord->forumacc = $forumId;
                $newRecord->forum_acc_url = $forumLink;
                $newRecord->nick = $findTrUser['nick'];
                R::store($newRecord);
            }

            forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) привязал @id{$trUser} форумный аккаунт с ID {$forumId} и ссылкой {$forumLink}!");
            $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) привязал форумный аккаунт ID {$forumId} и ссылкой {$forumLink}!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Приоритет команды: {$forum['bind']}  \n Ваш приоритет: {$adminCheck['lvl']} \n Команда недоступна!");
        exit;
    }
}
if (in_array($cmd, ['ftr'])) {
    if ($botAdmin) {
        // Получаем список участников беседы с помощью VK API
        $response = $vk->request('messages.getConversationMembers', ['peer_id' => $peer_id]);
        $chatMembers = $response['items'];
        foreach ($chatMembers as $member) {
            $memberId = $member['member_id'];
            // Ищем пользователя в таблице users
            $userRecord = R::findOne('users', 'user_id = ?', [$memberId]);
            if ($userRecord && $userRecord['forumacc'] && $userRecord['forum_url']) {
                // Если пользователь найден и у него есть привязка к форуму, ищем его в таблице faccess
                $faccessRecord = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$memberId, $chat_id]);
                if (!$faccessRecord) {
                    // Если запись не найдена, создаем новую
                    $faccessRecord = R::dispense('faccess');
                    $faccessRecord->user_id = $memberId;
                    $faccessRecord->beseda_id = $chat_id;
                }
                // Обновляем данные привязки к форуму
                $faccessRecord->forumacc = $userRecord['forumacc'];
                $faccessRecord->forum_acc_url = $userRecord['forum_url'];
                $faccessRecord->nick = $userRecord['nick'];
                // Сохраняем изменения в базе данных
                R::store($faccessRecord);
            }
        }
        forwardMessage($vk, $peer_id, $messageIdToReply, "Привязка к форуму обновлена для всех участников беседы.");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда  не может быть выполнена.");
        exit;
    }
}
if (in_array($cmd, ['гпривязка'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= $forum['gbind']) {
        $trUser = $reply_author;
        if ($trUser == '') {
            if ($args[0] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали кому изменить!");
                exit;
            }
            if ($args[1] == '') {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали ссылку на форумный аккаунт!");
                exit;
            }
            $trUser = $args[0];
            $forumLink = $args[1];
        }
        $trUser = preg_replace('/\D/', '', $trUser);
        if ($trUser == '') {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не указали кому изменить!");
            exit;
        } else {
            $forumId = preg_replace('/\D/', '', $forumLink);
            // Проверяем, включена ли беседа в пулл
            $pull = R::findOne('pulls', 'peer_ids LIKE ?', ["%{$peer_id}%"]);
            if ($pull) {
                // Если беседа включена в пулл, создаем запись о привязке для каждой беседы в пулле
                $chatIds = explode(',', $pull['peer_ids']);
                foreach ($chatIds as $chatId) {
                    $beseda_id = $chatId - 2000000000;
                    $findTrUser = R::findOne('faccess', 'user_id = ? AND beseda_id = ?', [$trUser, $beseda_id]);
                    if (!$findTrUser) {
                        $user1 = R::findOne('users', 'user_id = ?', [$trUser]);
                        // Если запись не найдена, создаем новую
                        $newRecord = R::dispense('faccess');
                        $newRecord->user_id = $trUser;
                        $newRecord->beseda_id = $beseda_id;
                        $newRecord->forumacc = $forumId;
                        $newRecord->forum_acc_url = $forumLink;
                        $newRecord->nick = $user1['nick']; // Эта строка вызывает ошибку, так как $findTrUser не существует
                        R::store($newRecord);
                    } else {
                        // Обновляем данные привязки к форуму
                        $findTrUser->forumacc = $forumId;
                        $findTrUser->forum_acc_url = $forumLink;
                        // Сохраняем изменения в базе данных
                        R::store($findTrUser);
                    }
                }
                forwardMessage($vk, $peer_id, $messageIdToReply, "@id{$id} ({$user['nick']}) привязал @id{$trUser} форумный аккаунт с ID {$forumId} и ссылкой {$forumLink} ко всем беседам в пулле!");
                $vk->sendMessage($trUser, "@id{$id} ({$user['nick']}) привязал форумный аккаунт ID {$forumId} и ссылкой {$forumLink} ко всем беседам в пулле!");
            } else {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Ваша беседа не включена в пулл.");
            }
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна.");
        exit;
    }
}

if (in_array($cmd, ['unforum'])) {
    $user = R::findOne('users', 'user_id = ?', [$user_id]);
    if ($user && $user->factivate > 0 && $peer_id == $id) {
        $forumUrl = isset($args[0]) ? trim($args[0]) : '';
        $apiKey = isset($args[1]) ? trim($args[1]) : '';
        $peerId = isset($args[2]) ? trim($args[2]) : '';
        $besedaId = $peerId - 2000000000;

        if ($forumUrl && $apiKey && $besedaId) {
            try {
                $settings = R::findOne('settings', 'peer_id = ?', [$peerId]);
                if ($settings && $settings['owner_id'] == $id) {
                    $forum = R::findOne('forums', 'beseda_id = ?', [$besedaId]);
                    if ($forum) {
                        R::trash($forum);

                        $user->factivate += 1;
                        R::store($user);

                        forwardMessage($vk, $peer_id, $messageIdToReply, "Форум успешно отвязан! Осталось активаций: {$user->factivate}");
                        $vk->sendMessage($peerId, "Форум: {$forumUrl} был успешно отвязан от данной беседы.");
                        $vk->sendMessage(2000000000, "Пользователь с ID {$user_id} отвязал форум {$forumUrl} от беседы {$besedaId}");
                        exit;
                    } else {
                        forwardMessage($vk, $peer_id, $messageIdToReply, "Форум не найден для данной беседы.");
                    }
                } else {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Вы не являетесь владельцем указанной беседы!");
                }
            } catch (Exception $e) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Произошла ошибка: " . $e->getMessage());
            }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка. Используйте: /unforum [url форума] [api-key] [id беседы(узнать через /chatinfo в беседе с ботом)]");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда не может быть выполнена. Возможные ошибки: \n\n 1. Вы отправили сообщение не в личные сообщения сообщества.\n2. Вы не использовали ключ активации.");
    }
}


if (in_array($cmd, ['fsettings'])) {
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum && $adminCheck['lvl'] >= 70) {
        if (count($args) >= 2) {
            $commandName = trim($args[0]); // Название команды
            $accessLevel = intval($args[1]); // Уровень доступа

            // Проверка на приоритет текущего пользователя
            if ($adminCheck['lvl'] <= $accessLevel) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Вы пытаетесь установить недопустимый для своего уровня приоритет!");
                exit;
            }

            // Извлекаем информацию о форуме из базы данных
            $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
            if(!$forum){
                forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
                return;
            }
            // Обновляем уровень доступа для указанной команды
            $forum[$commandName] = $accessLevel;
            R::store($forum);

            forwardMessage($vk, $peer_id, $messageIdToReply, "Уровень доступа для команды '{$commandName}' успешно обновлен до {$accessLevel}.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Неверные аргументы. Используйте: /fsettings [команда] [уровень доступа]\n Доступные команды:\n1. ftest\n2. fstats\n3. finfo\n4. new_colors (новыекраски)\n5. colorings (покраски)\n6. color (покрас)\n7. bind (привязать)\n8. gbind (гпривязка)\n9. fchangename");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команда недоступна.");
        exit;
    }
}
if (in_array($cmd, ['fhelp'])) {
    // Извлекаем информацию о форуме из базы данных
    $forum = R::findOne('forums', 'beseda_id = ?', [$chat_id]);
    if ($forum) {
        $message = "Вот все команды для взаимодействия с форумом:\n\n";
        $message .= "1. ftest - Проверка участников беседы на привязку форумного аккаунта.\n";
        $message .= "2. fstats - Показывает статистику пользователя на форуме.\n";
        $message .= "3. finfo - Показывает информацию о форумном аккаунте пользователя.\n";
        $message .= "4. новыекраски - Позволяет добавить свой список покрасок с ID.\n";
        $message .= "5. покраски - Показывает все доступные покраски.\n";
        $message .= "6. покрас - Меняет покраску пользователя на форуме.\n";
        $message .= "7. привязать - Привязывает аккаунт пользователя к его аккаунту на форуме.\n";
        $message .= "8. гпривязка - Привязывает аккаунт пользователя ко всем беседам в пулле.\n";
        $message .= "9. fsettings - Позволяет отредактировать уровень доступа к командам.\n";
        $message .= "10. fchangename - Изменяет ник пользователя на форуме.\n";
        forwardMessage($vk, $peer_id, $messageIdToReply, $message);
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К вашей беседе не привязан форум.");
    }
}


function generatePart($lettersCount, $numbersCount) {
    $letters = '';
    $numbers = '';

    // Генерация букв
    for ($i = 0; $i < $lettersCount; $i++) {
        $letters .= chr(rand(65, 90)); // ASCII код от A (65) до Z (90)
    }

    // Генерация цифр
    for ($i = 0; $i < $numbersCount; $i++) {
        $numbers .= rand(0, 9);
    }

    return $letters . $numbers;
}

function generateKey() {
    $keyParts = [];

    // Формат: XXX99-XXX99-99XXX-99XXX
    $keyParts[] = generatePart(3, 2);  // XXX99
    $keyParts[] = generatePart(3, 2);  // XXX99
    $keyParts[] = generatePart(2, 1);  // 99XXX
    $keyParts[] = generatePart(2, 2);  // 99XXX

    return implode('-', $keyParts);
}

if (in_array($cmd, ['generate'])) {
    if ($adminCheck['lvl'] > 1110) {
        $code = generateKey(); // Генерируем 10-значный код
        $timecode = R::dispense('timecodes');
        $timecode->code = $code;
        R::store($timecode);
        forwardMessage($vk, $peer_id, $messageIdToReply, "🆕 Сгенерированный ключи FORUM типа:\n\n$code\n\n");
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда доступна только технической администрации Blue.");
    }
}

if (in_array($cmd, ['generatepremium'])) {
    if ($adminCheck['lvl'] > 1110) {
        $argsCount = count($args);
        if ($argsCount == 1) {
        $code = generateKey(); // Генерируем 10-значный код
        $duration = (int)$args[0];
        $premiumcodes = R::dispense('premiumcodes');
        $premiumcodes->code = $code;
        $premiumcodes->duration = $duration;
        R::store($premiumcodes);
        forwardMessage($vk, $peer_id, $messageIdToReply, "🆕 Сгенерированный ключи PREMIUM типа:\n\n$code\n\n⏳Представленный выше ключ создан на $duration дней.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Корректное использование команды: /generatepremium [период работы PREMIUM в днях].");
        }
        } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда доступна только технической администрации Blue.");
    }
}

if (in_array($cmd, ['gmp'])) {
    if ($adminCheck['lvl'] > 1110) {
        $argsCount = count($args);
        $generationcount = $args[0];
        $dur = $args[1];
        if ($argsCount == 2) {
            $generationkeys = [];
            for ($i = 1; $i < $generationcount; $i++) {
                $genkey = generateKey();
                $generationkeys[] = $genkey;
                R::exec('INSERT INTO premiumcodes (code, duration) VALUES (?, ?)', [$genkey, $dur]);
            }
        $generatedkeysList = "   " . implode("\n   ", $generationkeys);
        forwardMessage($vk, $peer_id, $messageIdToReply, "🆕 Сгенерированные ключи PREMIUM типа:\n\n$generatedkeysList\n\n⏳Представленные выше ключи созданы на $dur дней.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Корректное использование команды: /gmp [количество ключей] [период работы PREMIUM в днях].");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда доступна только технической администрации Blue.");
    }
}

if (in_array($cmd, ['gmf'])) {
    if ($adminCheck['lvl'] > 110) {
        $argsCount = count($args);
        $generationcount = $args[0];
        if ($argsCount == 1) {
            $generationkeys = [];
            for ($i = 1; $i < $generationcount; $i++) {
                $genkey = generateKey();
                $generationkeys[] = $genkey;
                R::exec('INSERT INTO timecodes (code) VALUES (?)', [$genkey]);
            }
        $generatedkeysList = "   " . implode("\n   ", $generationkeys);
        forwardMessage($vk, $peer_id, $messageIdToReply, "🆕 Сгенерированные ключи FORUM типа:\n\n$generatedkeysList\n\n");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Корректное использование команды: /gmf [количество ключей]");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "⚒ Команда доступна только технической администрации Blue.");
    }
}

if (in_array($cmd, ['codepremium'])) {
    if ($peer_id == $id){
        if (isset($args[0]) && isset($args[1])){
        $code = trim($args[0]); // Введенный пользователем код
        $premiumcode = R::findOne('premiumcodes', 'code = ?', [$code]);
        $premiumDuration = $premiumcode->duration;
        $peerId = isset($args[1]) ? trim($args[1]) : '';
        $chatId = $peerId;
        if ($premiumcode) {
            R::trash($premiumcode); // Удаляем код из таблицы timecodes
            $chat = R::findOne('settings', 'peer_id = ?', [$chatId]);
            $chat->premium_chat = 1;
            $premiumEndDate = strtotime("+$premiumDuration days");
            $chat->premium_date = date("Y-m-d H:i:s", $premiumEndDate);
            R::store($chat);
            forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Серийный ключ успешно активирован в беседе с идентификатором $chat_id.\n\n🎉 В представленной Вами беседе был активирован Premium на $premiumDuration дней.\n\n⚒ Благодарим за покупку данной услуги, приятного пользования.");
            $vk->sendMessage(2000000000, "🔑 Серийный ключ ($code) был активирован в беседе ($chatId).\n\n👥 Активатор ключа: @id$user_id.\n❓ Тип ключа: PREMIUM.\n\n⏳ Длительность PREMIUM в указанной беседе теперь: $premiumDuration дней.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "❌ Данный серийный ключ не найден в базе данных. Если Вы считаете это ошибкой - обратитесь к [funtik_code|нам]!");
        }
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "💡 Использование команды: /codepremium [серийный ключ] [ID беседы].\n\n🧐 Подсказка! Узнать ID беседы можно, используя команду /chatinfo.");
         }
    } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "🔐 В целях Вашей безопасности использование данной команды разрешается только в личных сообщениях с ботом.");
    }
}

if (in_array($cmd, ['code'])) {
    if($peer_id == $id){
        $code = trim($args[0]); // Введенный пользователем код
        $timecode = R::findOne('timecodes', 'code = ?', [$code]);
        if ($timecode) {
            R::trash($timecode); // Удаляем код из таблицы timecodes
            $user = R::findOne('users', 'user_id = ?', [$user_id]);
            $user->factivate = 4;
            R::store($user);
            forwardMessage($vk, $peer_id, $messageIdToReply, "✅ Серийный ключ успешно активирован!\n\n ⚒ Благодарим за покупку данной услуги, приятного пользования.");
            $vk->sendMessage(2000000000, "🔑 Серийный ключ ($code) был активирован в беседе ($chatId).\n\n👥 Активатор ключа: @id$user_id.\n❓ Тип ключа: PREMIUM.\n\n⏳ Длительность PREMIUM в указанной беседе теперь: $premiumDuration дней.");
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "❌ Данный серийный ключ не найден в базе данных. Если Вы считаете это ошибкой - обратитесь к [funtik_code|нам]!");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "🔐 В целях Вашей безопасности использование данной команды разрешается только в личных сообщениях с ботом.");
    }
}

function extractUserId($input) {
    $patterns = [
        '/https:\/\/vk\.com\/(id\d+|[A-Za-z0-9_]+)/',
        '/https:\/\/m\.vk\.com\/(id\d+|[A-Za-z0-9_]+)/',
        '/https:\/\/vk\.me\/(id\d+|[A-Za-z0-9_]+)/',
        '/@(id\d+|[A-Za-z0-9_]+)/',
        '/(id\d+|[A-Za-z0-9_]+)/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input, $matches)) {
            return $matches[1];
        }
    }

    return '';
}
if ($cmd == 'getinvite') {
    if($adminCheck['lvl'] > 665){
        // Получаем ID беседы из аргументов команды
        $chat_id = $args[0];

        // Проверяем, состоит ли бот в беседе
        $chat = R::findOne('settings', 'peer_id = ?', [$chat_id]);
        if ($chat) {
            // Если бот состоит в беседе, запрашиваем пригласительную ссылку
            $response = $vk->request('messages.getInviteLink', [
                'peer_id' => $chat_id,
                'group_id' => GROUP_ID, // ID вашего сообщества
                'reset' => 0 // Пытаемся получить существующую ссылку
            ]);

            if (isset($response['link'])) {
                // Если ссылка успешно получена, отправляем ее пользователю
                forwardMessage($vk, $peer_id, $messageIdToReply, "Пригласительная ссылка на беседу: " . $response['link']);
            } else {
                // Если ссылку получить не удалось, сообщаем об этом пользователю
                forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить существующую пригласительную ссылку. Попробуем сгенерировать новую...");

                // Пытаемся сгенерировать новую ссылку
                $response = $vk->request('messages.getInviteLink', [
                    'peer_id' => $chat_id,
                    'group_id' => GROUP_ID, // ID вашего сообщества
                    'reset' => 1 // Генерируем новую ссылку
                ]);

                if (isset($response['link'])) {
                    // Если новая ссылка успешно сгенерирована, отправляем ее пользователю
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Новая пригласительная ссылка на беседу: " . $response['link']);
                } else {
                    // Если новую ссылку сгенерировать не удалось, отправляем сообщение об ошибке
                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось сгенерировать новую пригласительную ссылку на беседу.");
                }
            }
        } else {
            // Если бот не состоит в беседе, отправляем сообщение об ошибке
            forwardMessage($vk, $peer_id, $messageIdToReply, "Бот не состоит в указанной беседе.");
        }
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Команды не существует.");
        exit;
    }
}
//--------------------------------------------------------------------------
if ($chat_act->type == 'chat_kick_user') {
    // Автоматический кик из беседы
    $userInfo = $vk->request("users.get", ["user_ids" => $id]);
    $first_name = $userInfo[0]['first_name'];

    if ($chat_act->member_id <= '-') {
        exit; // Т.к. неправильный идентификатор, завершаем скрипт
    }

    $userId = $chat_act->member_id;

    // Удаление записи из таблицы nickname конкретной беседы
    $chatId = $chat_id;
    $userAdminRecord = R::findOne('usersadmin', 'user_id = ? AND beseda_id = ?', [$userId, $chat_id]);
    if ($userAdminRecord && $adminCheck['lvl'] < 100) {
        R::trash($userAdminRecord);
    }
    $userNicknameRecord = R::findOne('nickname', 'user_id = ? AND beseda_id = ?', [$userId, $chatId]);
    if ($userNicknameRecord) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userId}|$userNicknameRecord->nickname] вышел из беседы и был автоматически исключён!");
        R::trash($userNicknameRecord);

        // Получаем информацию о текущей беседе
        $chatInfo = R::findOne('settings', 'peer_id = ?', [$peer_id]);
        // Отправляем сообщения в техническую беседу
        if ($chatInfo && !empty($chatInfo->tech_peer)) {
            $techChatId = (int)$chatInfo->tech_peer;

            // Отправляем первое сообщение


        // Находим следующий доступный v_id
        $maxVId = R::findOne('botvladelec', 'ORDER BY v_id DESC LIMIT 1');
        $vladelecId = $maxVId ? $maxVId->v_id + 1 : 1; // Если записи нет, начинаем с 1

        // Сохраняем информацию об владельце в базу данных
        $gendirek = R::dispense('botvladelec');
        $gendirek->user_id = $userIdToGenDirek;
        $gendirek->name = $userName;
        $gendirek->v_id = $vladelecId;
        $gendirek->date = date('Y-m-d H:i:s');
        R::store($gendirek);

        // Проверка на существование пользователя в таблице 'users'
        $user = R::findOne('users', 'user_id = ?', [$userIdToGenDirek]);
        
        if ($user) {
            $user->bstatus = 600;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Ошибка: Пользователь с данным ID не найден в таблице 'users'.");
        }

        // Отправляем оповещение о назначении
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userIdToGenDirek}|$userName] был назначен Владельцем Blue!\n\nПосмотреть список доступных команд: /vhelp");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для них ’’antigamer ’’ и ‘‘fun Tik.");
    }
}



if ($cmd == 'giveruk') {
    // Проверяем уровень пользователя
    if ($id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToIspDirek = 0;

        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToIspDirek = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToIspDirek = (int)$matches[1];
        }

        if (empty($userIdToIspDirek)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/giveruk [USERID]");
            return;
        }

        // Получаем информацию о пользователе из VK API
        $userInfoIspDirek = $vk->request('users.get', ['user_ids' => $userIdToIspDirek]);
        $userName = $userInfoIspDirek[0]['first_name'] . ' ' . $userInfoIspDirek[0]['last_name'];

        // Получаем информацию об владельце из VK API
        $vidalInfo = $vk->request('users.get', ['user_ids' => $id]);
        $vidalName = $vidalInfo[0]['first_name'] . ' ' . $vidalInfo[0]['last_name'];

        // Находим следующий доступный ruk_id
        $maxRukId = R::findOne('botrukovoditel', 'ORDER BY ruk_id DESC LIMIT 1');
        $rukId = $maxRukId ? $maxRukId->ruk_id + 1 : 1; // Если записей нет, начинаем с 1

        // Сохраняем информацию о руководителе в базу данных
        $ispdirek = R::dispense('botrukovoditel');
        $ispdirek->user_id = $userIdToIspDirek;
        $ispdirek->name = $userName;
        $ispdirek->appointed_by = $vidalName;
        $ispdirek->ruk_id = $rukId; // Сохраняем значение ruk_id
        $ispdirek->date = date('Y-m-d H:i:s');
        R::store($ispdirek);

        // Проверка на существование пользователя в таблице 'users'
        $user = R::findOne('users', 'user_id = ?', [$userIdToIspDirek]);
        if ($user) {
            $user->bstatus = 500;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'.");
        }

        // Отправляем оповещение о назначении
        forwardMessage($vk, $peer_id, $messageIdToReply, "[id{$userIdToIspDirek}|$userName] был назначен Руководителем Blue!\n\nПосмотреть список доступных команд: /rukhelp");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для них ’’antigamer ’’ и ‘‘fun Tik.");
    }
}



if($cmd == 'removevladelec' || $cmd == 'снятьвладельца'){
    // Проверяем уровень пользователя
    if ($id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removevladelec [USERID]");
            return;
        }
        // Получаем разработчика из базы данных
        $razrab = R::findOne('botvladelec', 'user_id = ?', [$userIdToRemove]);
        if (!$razrab) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Владелец Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем разработчика из базы данных
        R::trash($razrab);
        R::exec('DELETE FROM usersadmin WHERE lvl > 110 AND user_id = ?', [$userIdToRemove]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Владелец Blue с ID $userIdToRemove был разжалован!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для них ’’antigamer ’’ и ‘‘fun Tik.");
    }
}

if($cmd == 'removedev' || $cmd == 'снятьразработчика'){
    // Проверяем уровень пользователя
    if ($id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removerazrab [USERID]");
            return;
        }
        // Получаем разработчика из базы данных
        $razrab = R::findOne('botdev', 'user_id = ?', [$userIdToRemove]);
        if (!$razrab) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Разработчик Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем разработчика из базы данных
        R::trash($razrab);
        R::exec('DELETE FROM usersadmin WHERE lvl > 110 AND user_id = ?', [$userIdToRemove]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Разработчик Blue с ID $userIdToRemove был разжалован!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для Владельца Blue и его Руководителя.");
    }
}


if($cmd == 'removeruk'){
    // Проверяем уровень пользователя
    if ($id == 678695202 || $id == 50776517) {
        // Получаем упоминание пользователя из аргументов команды
        $mention = isset($args[0]) ? $args[0] : '';
        $userIdToRemove = 0;
        // Извлекаем ID пользователя из упоминания или ссылки
        if (preg_match('/\[id(\d+)\|.*\]/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $mention, $matches)) {
            $userIdToRemove = (int)$matches[1];
        }
        if (empty($userIdToRemove)) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "/removeruk [USERID]");
            return;
        }
        // Получаем разработчика из базы данных
        $vladelec = R::findOne('botrukovoditel', 'user_id = ?', [$userIdToRemove]);
        if (!$vladelec) {
            forwardMessage($vk, $peer_id, $messageIdToReply, "Руководитель Blue с указанным ID не найден.");
            return;
        }
        $user = R::findOne('users', 'user_id =?', [$userIdToRemove]);
        if ($user) {
            $user->bstatus = 0;
            R::store($user);
        } else {
            forwardMessage($vk, $peer_id, $messageToReply, "Прощу прощения, ошибка: Пользователь с данным ID не был найден в таблице 'users'. ");
        }
        // Удаляем разработчика из базы данных
        R::trash($vladelec);
        R::exec('DELETE FROM usersadmin WHERE lvl > 110 AND user_id = ?', [$userIdToRemove]);
        forwardMessage($vk, $peer_id, $messageIdToReply, "Руководитель Blue с ID $userIdToRemove был разжалован!");
        exit;
    } else {
        forwardMessage($vk, $peer_id, $messageIdToReply, "Доступно только для них ’’antigamer ’’ и ‘‘fun Tik.");
    }
}


if (in_array($cmd, ['log', 'logs', 'лог'])) {
    $chat_ids = array(9, 10, 11, 12);
    if (in_array($chat_id, $chat_ids) && $adminCheck['lvl'] == 75) {
        forwardMessage($vk, $peer_id, $messageIdToReply, "К сожалению, технической администрации запрещено взаимодействовать с этой командой.");
        return;
    }
    if (isset($commandAccessLevels['log'])) {
        $requiredAccessLevel = $commandAccessLevels['log'];
        if ($adminCheck['lvl'] >= $requiredAccessLevel) {
            // Получаем информацию о пользователе, которому выдаем лог
            $targetUser = null;
            $reason = null;

            // Извлекаем ID пользователя из пересланного сообщения, если оно есть
            if (isset($data->object->fwd_messages) && !empty($data->object->fwd_messages)) {
                $targetUser = $data->object->fwd_messages[0]->from_id;
                $reason = trim(implode(' ', $args)); // Получаем причину
            } else {
                // Проверяем, был ли пользователь упомянут в сообщении
                preg_match('/\[id(\d+)\|.*\]/', $args[0], $matches);
                if (isset($matches[1]) && is_numeric($matches[1]) && $matches[1] > 0) {
                    $targetUser = (int)$matches[1]; // Если пользователь упомянут, извлекаем его ID
                    $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                } elseif (preg_match('/https:\/\/vk\.com\/id(\d+)/', $args[0], $matches)) {
                    $targetUser = (int)$matches[1];
                    $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                } elseif (preg_match('/https:\/\/vk\.com\/([a-zA-Z0-9_]+)/', $args[0], $matches)) {
                    $username = $matches[1];
                    $userInfo = $vk->request('utils.resolveScreenName', [
                        'screen_name' => $username,
                    ]);
                    if (isset($userInfo['type']) && $userInfo['type'] === 'user') {
                        $targetUser = $userInfo['object_id'];
                        $reason = trim(implode(' ', array_slice($args, 1))); // Получаем причину
                    }
                }
            }

            // Если не удалось определить целевого пользователя, отправляем сообщение об ошибке
            if (!$targetUser) {
                forwardMessage($vk, $peer_id, $messageIdToReply, "Используйте: /log [userid] [причина]!");
            } else {
                // Проверяем, состоит ли целевой пользователь в беседе
                $isMember = $vk->request('messages.getConversationMembers', [
                    'peer_id' => $peer_id,
                    'fields' => 'id',
                ]);

                $isMemberIds = array_column($isMember['items'], 'member_id');

                if (!in_array($targetUser, $isMemberIds)) {
                    forwardMessage($vk, $peer_id, $messageIdToReply, "[id$targetUser|Пользователь] не состоит в этой беседе и ему невозможно выдать лог.");
                } else {

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Не удалось получить информацию о пользователе [id$targetUser].");
                } else {
                    // Добавляем пользователя в базу данных
                    $user = R::dispense('users');
                    $user->user_id = $targetUser;
                    $user->first_name = $targetUserInfo[0]['first_name'];
                    $user->last_name = $targetUserInfo[0]['last_name'];
                    $user->balance = 0;]['sex'] ?? 2; // Если пол не указан, сохраняем 2 (мужской по умолчанию)
                    $user->reg_date = date('Y-m-d H:i:s');
                    $user->status = 0;
                    $user->score = 0;
                    R::store($user);

                    forwardMessage($vk, $peer_id, $messageIdToReply, "Пользователь [id$targetUser|{$targetUserInfo[0]['first_name']} {$targetUserInfo[0]['last_name']}] успешно зарегистрирован.");
                }
            }
        }
    } else {
        $messageerror = "Команда доступна только Разработчику бота!";
        forwardMessage($vk, $peer_id, $messageIdToReply, $messageerror);
    }
}

?>