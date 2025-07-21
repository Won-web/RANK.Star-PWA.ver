<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');


$lang['email_must_be_array'] = '이메일 유효성 검사 방법은 배열로 전달되어야 합니다.';
$lang['email_invalid_address'] = '잘못된 이메일 주소: %s';
$lang['email_attachment_missing'] = '다음 이메일 첨부 파일을 찾을 수 없음: %s';
$lang['email_attachment_unreadable'] = '이 첨부 파일을 열 수 없습니다: %s';
$lang['email_no_from'] = '보낸사람 헤더가 없는 메일은 보낼 수 없습니다.';
$lang['email_no_recipients'] = '받는 사람을 포함해야 합니다: 받는 사람, 참조 또는 숨은 참조';
$lang['email_send_failure_phpmail'] = 'PHP mail()을 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법을 사용하여 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_send_failure_sendmail'] = 'PHP Sendmail을 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법을 사용하여 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_send_failure_smtp'] = 'PHP SMTP를 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법을 사용하여 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_sent'] = '다음 프로토콜을 사용하여 메시지가 성공적으로 전송되었습니다: %s';
$lang['email_no_socket'] = 'Sendmail에 대한 소켓을 열 수 없습니다. 설정을 확인하세요.';
$lang['email_no_hostname'] = 'SMTP 호스트 이름을 지정하지 않았습니다.';
$lang['email_smtp_error'] = '다음 SMTP 오류가 발생했습니다: %s';
$lang['email_no_smtp_unpw'] = '오류: SMTP 사용자 이름과 암호를 지정해야 합니다.';
$lang['email_failed_smtp_login'] = 'AUTH LOGIN 명령어 전송 실패. 오류: %s';
$lang['email_smtp_auth_un'] = '사용자 이름 인증에 실패했습니다. 오류: %s';
$lang['email_smtp_auth_pw'] = '비밀번호 인증에 실패했습니다. 오류: %s';
$lang['email_smtp_data_failure'] = '데이터를 보낼 수 없음: %s';
$lang['email_exit_status'] = '종료 상태 코드: %s';
