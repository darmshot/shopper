<?php

declare(strict_types=1);

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
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('url')->unique();
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->json('images');
            $table->string('url')->unique();
            $table->string('name');
            $table->string('annotation')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->string('name')->nullable();
            $table->decimal('price', 14);
            $table->decimal('old_price', 14)->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('in_filter')->default(false);
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignUuid('feature_id')->constrained('features')->cascadeOnDelete();
            $table->primary(['product_id', 'feature_id']);
            $table->string('value');
            $table->unique(['product_id', 'feature_id', 'value']);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->unique();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->after('id')->nullable()->constrained('categories')->cascadeOnDelete();
        });
        DB::statement('
        ALTER TABLE categories
        ADD CONSTRAINT check_parent_not_self
        CHECK (parent_id IS NULL OR parent_id <> id)
        ');

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignUuid('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('sort')->default(0);
            $table->primary(['category_id', 'product_id']);
        });

        Schema::create('product_related', function (Blueprint $table) {
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignUuid('related_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('sort')->default(0);
            $table->primary(['product_id', 'related_id']);
        });

        Schema::create('category_feature', function (Blueprint $table) {
            $table->foreignUuid('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignUuid('feature_id')->constrained('features')->cascadeOnDelete();
            $table->primary(['category_id', 'feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_feature');
        Schema::dropIfExists('product_related');
        Schema::dropIfExists('category_product');
        DB::statement('ALTER TABLE categories DROP CONSTRAINT check_parent_not_self');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('options');
        Schema::dropIfExists('features');
        Schema::dropIfExists('variants');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
    }
};
