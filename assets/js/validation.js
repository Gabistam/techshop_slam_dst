var isFormValid = false;
var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
var passwordMinLength = 6;

function validateEmail(email) {
    if (email.length > 0) {
        if (emailPattern.test(email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validatePassword(password) {
    if (password.length >= passwordMinLength) {
        return true;
    } else {
        return false;
    }
}

function showError(elementId, message) {
    var errorElement = document.getElementById(elementId + '_error');
    if (errorElement) {
        errorElement.innerHTML = message;
        errorElement.style.display = 'block';
    } else {
        var newError = document.createElement('div');
        newError.id = elementId + '_error';
        newError.className = 'error-message';
        newError.innerHTML = message;
        newError.style.color = 'red';
        newError.style.fontSize = '12px';

        var targetElement = document.getElementById(elementId);
        if (targetElement) {
            targetElement.parentNode.insertBefore(newError, targetElement.nextSibling);
        }
    }
}

function hideError(elementId) {
    var errorElement = document.getElementById(elementId + '_error');
    if (errorElement) {
        errorElement.style.display = 'none';
    }
}

function setupRealTimeValidation() {
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');

    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            var email = this.value;
            if (email.length > 0) {
                if (validateEmail(email)) {
                    hideError('email');
                    this.style.borderColor = 'green';
                } else {
                    showError('email', 'Format d\'email invalide');
                    this.style.borderColor = 'red';
                }
            } else {
                showError('email', 'Email requis');
                this.style.borderColor = 'red';
            }
        });
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            var password = this.value;
            if (password.length > 0) {
                if (validatePassword(password)) {
                    hideError('password');
                    this.style.borderColor = 'green';
                } else {
                    showError('password', 'Mot de passe trop court (min ' + passwordMinLength + ' caractères)');
                    this.style.borderColor = 'red';
                }
            } else {
                showError('password', 'Mot de passe requis');
                this.style.borderColor = 'red';
            }
        });
    }
}

function validateForm() {
    var form = document.querySelector('form');
    var isValid = true;

    if (form) {
        var emailInput = form.querySelector('#email');
        var passwordInput = form.querySelector('#password');

        if (emailInput) {
            var emailValue = emailInput.value;
            if (emailValue.length > 0) {
                if (validateEmail(emailValue)) {
                    hideError('email');
                } else {
                    showError('email', 'Email invalide');
                    isValid = false;
                }
            } else {
                showError('email', 'Email requis');
                isValid = false;
            }
        }

        if (passwordInput) {
            var passwordValue = passwordInput.value;
            if (passwordValue.length > 0) {
                if (validatePassword(passwordValue)) {
                    hideError('password');
                } else {
                    showError('password', 'Mot de passe trop court');
                    isValid = false;
                }
            } else {
                showError('password', 'Mot de passe requis');
                isValid = false;
            }
        }
    }

    if (isValid) {
        console.log('Formulaire valide, tentative de connexion...');
        console.log('Email:', emailInput ? emailInput.value : 'non trouvé');
        console.log('Mot de passe:', passwordInput ? passwordInput.value : 'non trouvé');
    } else {
        console.log('Formulaire invalide, erreurs détectées');
    }

    return isValid;
}

function showMessage(message, type) {
    var messageContainer = document.getElementById('message-container');
    
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'message-container';
        document.body.insertBefore(messageContainer, document.body.firstChild);
    }
    
    var messageClass = '';
    if (type === 'success') {
        messageClass = 'alert alert-success';
    } else if (type === 'error') {
        messageClass = 'alert alert-error';
    } else {
        messageClass = 'alert alert-info';
    }
    
    messageContainer.innerHTML = '<div class="' + messageClass + '">' + message + '</div>';
    messageContainer.style.display = 'block';

    setTimeout(function() {
        if (messageContainer) {
            messageContainer.style.display = 'none';
        }
    }, 5000);
}

function validateSearch() {
    var searchInput = document.querySelector('input[name="q"]');
    
    if (searchInput) {
        var searchValue = searchInput.value.trim();
        
        if (searchValue.length > 0) {
            if (searchValue.length < 2) {
                showMessage('Terme de recherche trop court (minimum 2 caractères)', 'error');
                return false;
            } else if (searchValue.length > 100) {
                showMessage('Terme de recherche trop long (maximum 100 caractères)', 'error');
                return false;
            } else {
                console.log('Recherche pour:', searchValue);
                return true;
            }
        } else {
            showMessage('Veuillez saisir un terme de recherche', 'error');
            return false;
        }
    }
    
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de validation chargé');

    setupRealTimeValidation();

    var loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
                showMessage('Veuillez corriger les erreurs avant de continuer', 'error');
            }
        });
    }

    var searchForm = document.querySelector('form[action*="search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            if (!validateSearch()) {
                event.preventDefault();
            }
        });
    }

    var currentPage = window.location.pathname;
    localStorage.setItem('lastPage', currentPage);
    localStorage.setItem('visitTime', new Date().toISOString());

    var savedData = localStorage.getItem('userPreferences');
    if (savedData) {
        console.log('Données utilisateur récupérées:', savedData);
    }
});

function sanitizeInput(input) {
    return input.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function debugInfo() {
    console.log('=== DEBUG INFO ===');
    console.log('Page courante:', window.location.href);
    console.log('Cookies:', document.cookie);
    console.log('Local Storage:', localStorage);
    console.log('Session Storage:', sessionStorage);
    console.log('=================');
}

if (window.location.search.includes('debug=1')) {
    debugInfo();
}