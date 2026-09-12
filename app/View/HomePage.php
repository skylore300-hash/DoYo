<?php

namespace App\View;

final class HomePage
{
    public static function data(): array
    {
        return [
            'brands' => ['VERSACE', 'ZARA', 'GUCCI', 'PRADA', 'Calvin Klein'],
            'newProducts' => [
                [
                    'name' => 'T-shirt avec bandes',
                    'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=700&q=85',
                    'price' => '$120', 'rating' => '4.5/5', 'reviews' => '132',
                ],
                [
                    'name' => 'Jean coupe slim',
                    'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=700&q=85',
                    'price' => '$240', 'oldPrice' => '$260', 'discount' => '-20%', 'rating' => '3.5/5', 'reviews' => '98',
                ],
                [
                    'name' => 'Chemise à carreaux',
                    'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=700&q=85',
                    'price' => '$180', 'rating' => '4.5/5', 'reviews' => '104',
                ],
                [
                    'name' => 'T-shirt à manches rayées',
                    'image' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&w=700&q=85',
                    'price' => '$130', 'oldPrice' => '$160', 'discount' => '-30%', 'rating' => '4.5/5', 'reviews' => '117',
                ],
            ],
            'bestSellers' => [
                [
                    'name' => 'Chemise à rayures verticales',
                    'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&w=700&q=85',
                    'price' => '$212', 'oldPrice' => '$232', 'discount' => '-20%', 'rating' => '5.0/5', 'reviews' => '82',
                ],
                [
                    'name' => 'T-shirt graphique courage',
                    'image' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?auto=format&fit=crop&w=700&q=85',
                    'price' => '$145', 'rating' => '4.0/5', 'reviews' => '76',
                ],
                [
                    'name' => 'Bermuda coupe ample',
                    'image' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?auto=format&fit=crop&w=700&q=85',
                    'price' => '$80', 'rating' => '3.0/5', 'reviews' => '64',
                ],
                [
                    'name' => 'Jean slim délavé',
                    'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=700&q=85',
                    'price' => '$210', 'rating' => '4.5/5', 'reviews' => '93',
                ],
            ],
            'styles' => [
                ['name' => 'Décontracté', 'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=900&q=85'],
                ['name' => 'Élégant', 'image' => 'https://images.unsplash.com/photo-1617127365659-c47fa864d8bc?auto=format&fit=crop&w=900&q=85'],
                ['name' => 'Soirée', 'image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=900&q=85'],
                ['name' => 'Sport', 'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=900&q=85'],
            ],
            'testimonials' => [
                ['name' => 'Sarah M.', 'text' => 'La qualité et le style des vêtements m’ont impressionnée. Chaque pièce reçue est soignée, actuelle et conforme à mes attentes.'],
                ['name' => 'Alex K.', 'text' => 'J’ai enfin trouvé des vêtements qui correspondent à mon style. Le choix est varié et convient à de nombreuses occasions.'],
                ['name' => 'James L.', 'text' => 'Une belle découverte pour trouver des pièces originales. La sélection est variée, actuelle et facile à associer.'],
                ['name' => 'Mouna B.', 'text' => 'Une expérience simple, des coupes modernes et une livraison qui tient ses promesses.'],
            ],
        ];
    }
}
