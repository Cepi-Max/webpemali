<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tombol Launching Website Desa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #ffffff; /* sky-950 */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .launch-button {
            position: relative;
            display: inline-block;
            padding: 30px 80px;
            background: #0c4a6e;
            color: #ffffff; /* sky-950 */
            text-decoration: none;
            font-size: 2.2rem;
            font-weight: 700;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(12, 74, 110, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 4px solid #ffffff;
        }

        .launch-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(12, 74, 110, 0.1), transparent);
            transition: left 0.6s;
        }

        .launch-button:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 30px 60px rgba(12, 74, 110, 0.4);
            background: #0c4a6e; /* sky-950 */
            color: #ffffff;
            border-color: #0c4a6e;
        }

        .launch-button:hover:before {
            left: 100%;
        }

        .launch-button:active {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 25px 50px rgba(12, 74, 110, 0.35);
        }

        .rocket-icon {
            display: inline-block;
            margin-left: 15px;
            animation: rocket 2s ease-in-out infinite alternate;
            font-size: 2.5rem;
        }

        @keyframes rocket {
            0% {
                transform: translateY(0px);
            }
            100% {
                transform: translateY(-8px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        .pulse-animation {
            animation: pulse 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .launch-button {
                padding: 25px 60px;
                font-size: 1.8rem;
                letter-spacing: 1px;
            }
            
            .rocket-icon {
                font-size: 2rem;
                margin-left: 10px;
            }
        }

        @media (max-width: 480px) {
            .launch-button {
                padding: 20px 40px;
                font-size: 1.5rem;
            }
            
            .rocket-icon {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('show.dashboard') }}" class="launch-button pulse-animation" onclick="launchWebsite()">
        Launch Website
        <span class="rocket-icon">🚀</span>
    </a>

    <script>
        function launchWebsite() {
            const button = document.querySelector('.launch-button');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = 'Launching... <span class="rocket-icon" style="animation: none;">🚀</span>';
            button.style.background = '#0c4a6e';
            button.style.color = '#ffffff';
            button.style.borderColor = '#0c4a6e';
            button.classList.remove('pulse-animation');
            
            setTimeout(() => {
                button.innerHTML = 'Success! <span class="rocket-icon" style="animation: none;">✅</span>';
                
                // Show success message
                setTimeout(() => {
                    alert('🎉 Website desa berhasil diluncurkan!');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '#ffffff';
                        button.style.color = '#0c4a6e';
                        button.style.borderColor = '#ffffff';
                        button.classList.add('pulse-animation');
                    }, 2000);
                }, 1000);
            }, 2500);
        }
    </script>
</body>
</html>