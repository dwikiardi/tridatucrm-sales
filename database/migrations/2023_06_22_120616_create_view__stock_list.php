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
            SELECT stocks.id,stocks.stockid,stocks.stockname,stocks_position.qty,leads.leadsname as Name, stocks_position.posmodule as modules,stocks_position.module_id as moduleid from stocks_position INNER JOIN stocks on stocks.id=stocks_position.stockid INNER JOIN leads on leads.id = stocks_position.module_id where stocks.qtytype=0 and stocks_position.posmodule='lead'
            union ALL
            SELECT stocks.id,stocks.stockid,stocks.stockname,stocks_position.qty,'Storage' as Name, stocks_position.posmodule as modules,stocks_position.module_id as moduleid from stocks_position INNER JOIN stocks on stocks.id=stocks_position.stockid  where stocks.qtytype=0 and stocks_position.posmodule='storeage'
            union ALL
            SELECT stocks.id,stocks.stockid, stocks.stockname,Count(stocks_no_seri.noseri) AS qty, 'Storage' as Name, stocks_no_seri.posmodule as modules, stocks_no_seri.module_id as moduleid
            FROM (stocks INNER JOIN stock_categories ON stocks.categoryid = stock_categories.id) INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid
            GROUP BY stocks.id,stocks.stockid, stocks.stockname, stock_categories.category_name, stocks.qtytype, stocks_no_seri.posmodule,  stocks_no_seri.module_id
            HAVING (((stocks_no_seri.posmodule)='storeage') AND ((stocks.qtytype)=1))

            union ALL
            SELECT stocks.id,stocks.stockid, stocks.stockname,  Count(stocks_no_seri.noseri) AS qty, leads.leadsname as Name, stocks_no_seri.posmodule as modules, stocks_no_seri.module_id as moduleid
            FROM ((stocks INNER JOIN stock_categories ON stocks.categoryid = stock_categories.id) INNER JOIN stocks_no_seri ON stocks.id = stocks_no_seri.stockid) INNER JOIN leads ON stocks_no_seri.module_id = leads.id
            GROUP BY stocks.id,stocks.stockid, stocks.stockname, stock_categories.category_name, stocks_no_seri.posmodule, leads.leadsname, stocks.qtytype, stocks_no_seri.module_id
            HAVING (((stocks_no_seri.posmodule)='lead') AND ((stocks.qtytype)=1));

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
