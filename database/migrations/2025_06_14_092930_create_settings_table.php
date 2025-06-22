    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('settings', function (Blueprint $table) {
                // 'key' akan menjadi primary key, contoh: 'company_name', 'tax_rate'
                $table->string('key')->primary();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
        public function down(): void
        {
            Schema::dropIfExists('settings');
        }
    };
