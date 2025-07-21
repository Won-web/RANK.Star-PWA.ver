<?php
$sub_menu = '500120';
include_once('./_common.php');
$g5['title'] = "주문내역";
include_once(G5_PATH.'/head.sub.php');
$ct_status = $_GET['ct_status'];

?>

<div id="sodr_print_pop" class="new_win">
    <h1>
        주문상세내역보기
    </h1>

    <?php
    $mod = 10;
    $tot_total_price = 0;
    
    
    $sql123 = " select * from {$g5['g5_shop_order_table']}
                       where od_id = '{$_GET['od_id']}'";

            $res123 = sql_fetch($sql123);
            
    ?>
    <!-- 반복시작 - 지운아빠 2013-04-18 -->
    <div class="sodr_print_pop_list">
        <h2>주문번호 <?php echo $res123['od_id']; ?> (상태 : <?php echo $res123['od_status']?>)</h2>
        <h3>보내는 사람 : <?php echo get_text($res123['od_name']); ?></h3>

        <dl>
            <dt>주소</dt>
            <dd><?php echo get_text($res123['od_addr1']); ?> <?php echo get_text($res123['od_addr2']); ?></dd>
            <dt>휴대폰</dt>
            <dd><?php echo get_text($res123['od_hp']); ?></dd>
            <dt>전화번호</dt>
            <dd><?php echo get_text($res123['od_tel']); ?></dd>
        </dl>
        <?php if ($samesamesame) { ?>
        <p class="sodr_print_pop_same">보내는 사람과 받는 사람이 동일합니다.</p>
        <?php } else { ?>
        <h3>받는 사람 : <?php echo get_text($res123['od_b_name']); ?></h3>
        <dl>
            <dt>주소</dt>
            <dd><?php echo get_text($res123['od_b_addr1']); ?> <?php echo get_text($res123['od_b_addr2']); ?></dd>
            <dt>휴대폰</dt>
            <dd><?php echo get_text($res123['od_b_hp']); ?></dd>
            <dt>전화번호</dt>
            <dd><?php echo get_text($res123['od_b_tel']); ?></dd>
        </dl>
        <?php } ?>

        <h3>주문 목록</h3>
        <div class="tbl_head01">
            <table>
            <caption>주문 목록</caption>
            <thead>
            <tr>
                <th scope="col">상품명(선택사항)</th>
                <th scope="col">판매가</th>
                <th scope="col">수량</th>
                <th scope="col">소계</th>
                <th scope="col">배송비</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql2 = " select *
                        from {$g5['g5_shop_cart_table']}
                       where od_id = '{$_GET['od_id']}' ";
            if ($ct_status)
                $sql2 .= " and ct_status = '$ct_status' ";
            $sql2 .= "  order by it_id, io_type, ct_id ";

            $res2 = sql_query($sql2);
            $cnt = $sub_tot_qty = $sub_tot_price = 0;
            $save_it_id = '';

            while ($row2 = sql_fetch_array($res2))
            {
                if($row2['io_type']) {
                    $it_price = $row2['io_price'];
                    $row2_tot_price = $row2['io_price'] * $row2['ct_qty'];
                } else {
                    $it_price = $row2['ct_price'] + $row2['io_price'];
                    $row2_tot_price = ($row2['ct_price'] + $row2['io_price']) * $row2['ct_qty'];
                }
                $sub_tot_qty += $row2['ct_qty'];
                $sub_tot_price += $row2_tot_price;

                $it_name = stripslashes($row2['it_name']);
                $price_plus = '';
                if($row2['io_price'] >= 0)
                    $price_plus = '+';

                $it_name = "$it_name ({$row2['ct_option']} ".$price_plus.display_price($row2['io_price']).")";

                if($save_it_id != $row2['it_id']) {
                    switch($row2['ct_send_cost'])
                    {
                        case 1:
                            $ct_send_cost = '착불';
                            break;
                        case 2:
                            $ct_send_cost = '무료';
                            break;
                        default:
                            $ct_send_cost = '선불';
                            break;
                    }

                    // 합계금액 계산
                    $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                    SUM(ct_qty) as qty
                                from {$g5['g5_shop_cart_table']}
                                where it_id = '{$row2['it_id']}'
                                  and od_id = '{$row2['od_id']}' ";
                    $sum = sql_fetch($sql);

                    // 조건부무료
                    if($row2['it_sc_type'] == 2) {
                        $sendcost = get_item_sendcost($row2['it_id'], $sum['price'], $sum['qty'], $row['od_id']);

                        if($sendcost == 0)
                            $ct_send_cost = '무료';
                    }

                    $save_it_id = $row2['it_id'];
                }

                $fontqty1 = $fontqty2 = "";
                if ($row2['ct_qty'] >= 2)
                {
                    $fontqty1 = "<strong>";
                    $fontqty2 = "</strong>";
                }

            ?>
            <tr>
                <td><?php echo $it_name; ?></td>
                <td class="td_num"><?php echo number_format($it_price); ?></td>
                <td class="td_cntsmall"><?php echo $fontqty1; ?><?php echo number_format($row2['ct_qty']); ?><?php echo $fontqty2; ?></td>
                <td class="td_num td_numsum"><?php echo number_format($row2_tot_price); ?></td>
                <td class="td_sendcost_by"><?php echo $ct_send_cost; ?></td>
            </tr>
            <?php
                $cnt++;
            }
            ?>
            <tr>
                <td>배송비</td>
                <td class="td_num"><?php echo number_format($res123['od_send_cost']); ?></td>
                <td class="td_cntsmall"><?php echo $fontqty1; ?>1<?php echo $fontqty2; ?></td>
                <td class="td_num td_numsum"><?php echo number_format($res123['od_send_cost']); ?></td>
                <td class="td_sendcost_by"></td>
            </tr>
            <tr>
                <td>추가 배송비</td>
                <td class="td_num"><?php echo number_format($res123['od_send_cost2']); ?></td>
                <td class="td_cntsmall"><?php echo $fontqty1; ?>1<?php echo $fontqty2; ?></td>
                <td class="td_num td_numsum"><?php echo number_format($res123['od_send_cost2']); ?></td>
                <td class="td_sendcost_by"></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th scope="row" colspan="2">합계</th>
                <td><?php echo number_format($sub_tot_qty + 2); ?></td>
                <td><?php echo number_format($sub_tot_price + $res123['od_send_cost'] + $res123['od_send_cost2']); ?></td>
                <td></td>
            </tr>
            </tfoot>
            </table>
        </div>
        <?php
        $tot_tot_qty    += ($sub_tot_qty + 2);
        $tot_tot_price  += ($sub_tot_price + $res123['od_send_cost'] + $res123['od_send_cost2']);

        if ($od_memo) $od_memo = "<p><strong>비고</strong> $od_memo</p>";
        if ($od_shop_memo) $od_shop_memo = "<p><strong>상점메모</strong> $od_shop_memo</p>";

        echo "
                $od_memo
                $od_shop_memo
        ";
       ?>
    </div>
    <!-- 반복 끝 -->

    <div id="sodr_print_pop_total">
        <span>
            전체
            <strong><?php echo number_format($tot_tot_qty); ?></strong>개
            <strong><?php echo number_format($tot_tot_price); ?></strong>원
        </span>
        &lt;출력 끝&gt;
    </div>

</div>


</body>
</html>