<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('livelihoods', function (Blueprint $table) {
            $table->id();

            /* ================== معلومات عمومی ================== */
            $table->string('livelihoodDate');

            $table->unsignedBigInteger('week_day_id');
            $table->foreign('week_day_id')
                ->references('id')
                ->on('week_days');




            // MONEY / TOTAL
            $table->decimal('amount', 18, 6)->default(0);

            /* ================== حبوبات و مواد اولیه ================== */
            $table->decimal('rice', 18, 6)->default(0);
            $table->decimal('sugar', 18, 6)->default(0);
            $table->decimal('green_tea', 18, 6)->default(0);
            $table->decimal('beans', 18, 6)->default(0);
            $table->decimal('chickpeas', 18, 6)->default(0);

            /* ================== لبنیات، پروتئین و گوشت ================== */
            $table->decimal('milk_powder', 18, 6)->default(0);
            $table->decimal('eggs')->default(0);
            $table->decimal('oil', 18, 6)->default(0);
            $table->decimal('mutton', 18, 6)->default(0);
            $table->decimal('chicken', 18, 6)->default(0);
            $table->decimal('beef', 18, 6)->default(0);
            $table->decimal('cake', 18, 6)->default(0);
            $table->decimal('yogurt_drink', 18, 6)->default(0);
            $table->decimal('dates', 18, 6)->default(0);
            $table->decimal('sweets', 18, 6)->default(0);

            /* ================== سبزیجات ================== */
            $table->decimal('eggplant', 18, 6)->default(0);
            $table->decimal('zucchini', 18, 6)->default(0);
            $table->decimal('potato', 18, 6)->default(0);
            $table->decimal('potato_cooked', 18, 6)->default(0);
            $table->decimal('fasila', 18, 6)->default(0);
            $table->decimal('onion', 18, 6)->default(0);
            $table->decimal('tomato', 18, 6)->default(0);
            $table->decimal('cucumber', 18, 6)->default(0);
            $table->decimal('salad', 18, 6)->default(0);
            $table->decimal('lemon', 18, 6)->default(0);

            /* ================== مواد متفرقه ================== */
            $table->decimal('salt', 18, 6)->default(0);
            $table->decimal('raisin_rice', 18, 6)->default(0);
            $table->decimal('dry_bread', 18, 6)->default(0);
            $table->decimal('spice_pot', 18, 6)->default(0);
            $table->decimal('gas', 18, 6)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livelihoods');
    }
};
