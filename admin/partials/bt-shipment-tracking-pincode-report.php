<div class="box">
    <tabel class="table">
        <thead>
            <tr>
                <th>Pincode</th>
                <th>City</th>
                <th>Min Date</th>
                <th>Min Date Charges</th>
                <th>Max Date</th>
                <th>Max Date Charges</th>
                <th>Time</th>
            </tr>
        </thead><br>
        <tbody>
            <?php
            $pincode_report = get_option("bt_sst_product_page_pincode_checker_logs", []);
            foreach ($pincode_report as $a) {
                echo "<tr>
				<td>" . $a['pincode'] . "</td>
				<td>" . $a['city'] . "</td>
				<td>" . $a['min_date'] . "</td>
				<td>" . $a['min_date_charges'] . "</td>
				<td>" . $a['max_date'] . "</td>
				<td>" . $a['max_date_charges'] . "</td>
				<td>" . $a['time'] . "</td>
				</tr><br>";
            }
            ?>
        </tbody>
    </table>
</div>