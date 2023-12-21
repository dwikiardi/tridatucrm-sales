<?php
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $query = "
        CREATE VIEW stocklist AS 
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stocks_position.qty,
            leads.property_name AS NAME,
            stocks_position.posmodule AS modules,
            stocks_position.module_id AS moduleid
        FROM
            stocks_position
        INNER JOIN stocks ON stocks.id = stocks_position.stockid
        INNER JOIN leads ON leads.id = stocks_position.module_id
        WHERE
            stocks.qtytype = 0 AND stocks_position.posmodule = 'leads'
        UNION ALL
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stocks_position.qty,
            'Storage' AS NAME,
            stocks_position.posmodule AS modules,
            stocks_position.module_id AS moduleid
        FROM
            stocks_position
        INNER JOIN stocks ON stocks.id = stocks_position.stockid
        WHERE
            stocks.qtytype = 0 AND stocks_position.posmodule = 'storage'
        UNION ALL
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stocks_position.qty,
            users.first_name AS NAME,
            stocks_position.posmodule AS modules,
            stocks_position.module_id AS moduleid
        FROM
            stocks_position
        INNER JOIN stocks ON stocks.id = stocks_position.stockid
        INNER JOIN users ON users.id = stocks_position.module_id
        WHERE
            stocks.qtytype = 0 AND stocks_position.posmodule = 'staff'
        UNION ALL
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            COUNT(stocks_no_seri.noseri) AS qty,
            'Storage' AS NAME,
            stocks_no_seri.posmodule AS modules,
            stocks_no_seri.module_id AS moduleid
        FROM
            (
                stocks
            INNER JOIN stock_categories ON stocks.categoryid = stock_categories.id
            )
        INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid
        GROUP BY
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stock_categories.category_name,
            stocks.qtytype,
            stocks_no_seri.posmodule,
            stocks_no_seri.module_id
        HAVING
            (
                (
                    (stocks_no_seri.posmodule) = 'storage'
                ) AND((stocks.qtytype) = 1)
            )
        UNION ALL
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            COUNT(stocks_no_seri.noseri) AS qty,
            leads.property_name AS NAME,
            stocks_no_seri.posmodule AS modules,
            stocks_no_seri.module_id AS moduleid
        FROM
            (
                (
                    stocks
                INNER JOIN stock_categories ON stocks.categoryid = stock_categories.id
                )
            INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid
            )
        INNER JOIN leads ON stocks_no_seri.module_id = leads.id
        GROUP BY
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stock_categories.category_name,
            stocks_no_seri.posmodule,
            leads.property_name,
            stocks.qtytype,
            stocks_no_seri.module_id
        HAVING
            (
                (
                    (stocks_no_seri.posmodule) = 'leads'
                ) AND((stocks.qtytype) = 1)
            )
        UNION ALL
        SELECT
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            COUNT(stocks_no_seri.noseri) AS qty,
            users.first_name AS NAME,
            stocks_no_seri.posmodule AS modules,
            stocks_no_seri.module_id AS moduleid
        FROM
            (
                (
                    stocks
                INNER JOIN stock_categories ON stocks.categoryid = stock_categories.id
                )
            INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid
            )
        INNER JOIN users ON stocks_no_seri.module_id = users.id
        GROUP BY
            stocks.id,
            stocks.stockid,
            stocks.stockname,
            stock_categories.category_name,
            stocks_no_seri.posmodule,
            users.first_name,
            stocks.qtytype,
            stocks_no_seri.module_id
        HAVING
            (
                (
                    (stocks_no_seri.posmodule) = 'leads'
                ) AND((stocks.qtytype) = 1)
            );

        ";
        \DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('DROP VIEW IF EXISTS stocklist');
    }
};
