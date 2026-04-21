<?php ob_start(); ?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-10">
    <div class="bg-indigo-600 p-4">
        <h2 class="text-2xl font-bold text-white text-center">Créer un compte</h2>
    </div>
    <div class="p-6">
        <form action="/register" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-bold mb-2">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Mot de passe</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                S'inscrire
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="/login" class="text-sm text-indigo-600 hover:underline">Déjà un compte ? Connectez-vous</a>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
?>