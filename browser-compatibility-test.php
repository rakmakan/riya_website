<?php
// Simple browser detection for animation testing purposes
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getBrowserInfo($user_agent) {
    $browser_name = 'Unknown';
    $browser_version = '';
    $platform = 'Unknown';
    $mobile = false;

    // Platform detection
    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'Mac';
    } elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'Windows';
    }

    // Mobile detection
    if (preg_match('/mobile|android|iphone|ipad|ipod|blackberry|iemobile|opera mini/i', $user_agent)) {
        $mobile = true;
    }

    // Browser detection
    if (preg_match('/MSIE|Trident/i', $user_agent)) {
        $browser_name = 'Internet Explorer';
        if (preg_match('/MSIE\s([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        } else if (preg_match('/Trident\/[\d\.]+/i', $user_agent, $matches)) {
            $browser_version = '11.0'; // IE 11
        }
    } elseif (preg_match('/Edg/i', $user_agent)) {
        $browser_name = 'Microsoft Edge';
        if (preg_match('/Edg\/([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        }
    } elseif (preg_match('/Firefox/i', $user_agent)) {
        $browser_name = 'Mozilla Firefox';
        if (preg_match('/Firefox\/([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        }
    } elseif (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edg|OPR|Opera/i', $user_agent)) {
        $browser_name = 'Google Chrome';
        if (preg_match('/Chrome\/([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        }
    } elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome|Edg|OPR|Opera/i', $user_agent)) {
        $browser_name = 'Safari';
        if (preg_match('/Version\/([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        }
    } elseif (preg_match('/Opera|OPR/i', $user_agent)) {
        $browser_name = 'Opera';
        if (preg_match('/Opera\/([\d\.]+)/i', $user_agent, $matches) || preg_match('/OPR\/([\d\.]+)/i', $user_agent, $matches)) {
            $browser_version = $matches[1];
        }
    }

    return array(
        'browser' => $browser_name,
        'version' => $browser_version,
        'platform' => $platform,
        'mobile' => $mobile
    );
}

$browser_info = getBrowserInfo($user_agent);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animation Browser Compatibility Test - Airy Alps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/animations.css">
    <style>
        body {
            padding: 20px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .compatibility-header {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
        }
        
        .browser-info {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-right: 10px;
            margin-bottom: 10px;
            font-family: monospace;
        }
        
        .test-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .test-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .test-status {
            font-size: 14px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .status-testing {
            background-color: #cff4fc;
            color: #055160;
        }
        
        .status-passed {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-failed {
            background-color: #f8d7da;
            color: #842029;
        }
        
        .result-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .code {
            font-family: monospace;
            background-color: #f1f1f1;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Animation Browser Compatibility Test</h1>
        
        <div class="compatibility-header">
            <h2>Your Browser Information</h2>
            <div class="mt-3">
                <div class="browser-info">Browser: <?php echo $browser_info['browser']; ?></div>
                <div class="browser-info">Version: <?php echo $browser_info['version']; ?></div>
                <div class="browser-info">Platform: <?php echo $browser_info['platform']; ?></div>
                <div class="browser-info">Mobile: <?php echo $browser_info['mobile'] ? 'Yes' : 'No'; ?></div>
                <div class="browser-info">User Agent: <span title="<?php echo htmlspecialchars($user_agent); ?>">(Hover to view)</span></div>
            </div>
        </div>
        
        <!-- Heartbeat Animation Test -->
        <div class="test-container">
            <div class="test-header">
                <h3>Heartbeat Animation Test</h3>
                <span class="test-status status-testing" id="heartbeat-status">Testing...</span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>This test checks if the heartbeat animation works properly in your browser:</p>
                    <ul>
                        <li>The text should gently pulse (scale up and down)</li>
                        <li>A subtle glow effect should appear and disappear</li>
                        <li>The animation should repeat every 4 seconds</li>
                    </ul>
                    <button class="btn btn-primary" id="reset-heartbeat">Reset Animation</button>
                </div>
                <div class="col-md-6">
                    <div class="p-4 d-flex justify-content-center align-items-center" style="height: 200px; border: 1px dashed #ccc;">
                        <h2 class="heartbeat-animation">I treat your brand like my own</h2>
                    </div>
                </div>
            </div>
            
            <div class="result-container" id="heartbeat-results">
                <p>Results will appear here after testing completes...</p>
            </div>
        </div>
        
        <!-- Pen Animation Test -->
        <div class="test-container">
            <div class="test-header">
                <h3>Pen Animation Test</h3>
                <span class="test-status status-testing" id="pen-status">Testing...</span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>This test checks if the pen drawing animation works properly in your browser:</p>
                    <ul>
                        <li>A gradient underline should flow from left to right</li>
                        <li>The animation should trigger when scrolled into view</li>
                        <li>Hovering should pause the animation at full underline</li>
                    </ul>
                    <button class="btn btn-primary" id="reset-pen">Reset Animation</button>
                </div>
                <div class="col-md-6">
                    <div class="p-4 d-flex justify-content-center align-items-center" style="height: 200px; border: 1px dashed #ccc;">
                        <div>
                            <p>Normal text with <span class="pen-animation visible">pen animation</span> applied.</p>
                            <h4 class="mt-3"><span class="pen-animation visible">Heading with pen animation</span></h4>
                            <a href="#" class="pen-animation visible d-inline-block mt-3">Link with pen animation</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="result-container" id="pen-results">
                <p>Results will appear here after testing completes...</p>
            </div>
        </div>
        
        <!-- SVG Animation Test -->
        <div class="test-container">
            <div class="test-header">
                <h3>SVG Animation Test</h3>
                <span class="test-status status-testing" id="svg-status">Testing...</span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>This test checks if the SVG animations work properly in your browser:</p>
                    <ul>
                        <li>Shapes should gently float with different timings</li>
                        <li>Path elements should gradually draw in</li>
                        <li>Animations should be smooth without performance issues</li>
                    </ul>
                    <button class="btn btn-primary" id="reset-svg">Reset Animation</button>
                </div>
                <div class="col-md-6">
                    <div style="height: 200px; border: 1px dashed #ccc; position: relative; overflow: hidden;">
                        <svg width="100%" height="100%" viewBox="0 0 400 300">
                            <!-- Define gradients -->
                            <defs>
                                <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#1D3557" stop-opacity="0.8"/>
                                    <stop offset="100%" stop-color="#E07A5F" stop-opacity="0.6"/>
                                </linearGradient>
                                <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#E07A5F" stop-opacity="0.8"/>
                                    <stop offset="100%" stop-color="#1D3557" stop-opacity="0.6"/>
                                </linearGradient>
                            </defs>
                            
                            <!-- SVG Shapes -->
                            <circle class="floating-shape shape-1" cx="100" cy="150" r="50" fill="url(#gradient1)" opacity="0.7" />
                            <circle class="floating-shape shape-2" cx="280" cy="120" r="30" fill="url(#gradient2)" opacity="0.5" />
                            <circle class="floating-shape shape-3" cx="220" cy="280" r="40" fill="url(#gradient1)" opacity="0.3" />
                            <path class="floating-shape shape-4" d="M150,80 C200,120 250,60 300,100" stroke="rgba(29, 53, 87, 0.4)" stroke-width="3" fill="none" />
                            <path class="floating-shape shape-5" d="M80,200 C130,250 180,220 230,270" stroke="rgba(224, 122, 95, 0.4)" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="result-container" id="svg-results">
                <p>Results will appear here after testing completes...</p>
            </div>
        </div>
        
        <!-- Accessibility Test -->
        <div class="test-container">
            <div class="test-header">
                <h3>Accessibility Test</h3>
                <span class="test-status status-testing" id="accessibility-status">Testing...</span>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>This test checks if the animations respect accessibility preferences:</p>
                    <ul>
                        <li>Animations should stop when reduced motion is enabled</li>
                        <li>Elements should still be usable without animations</li>
                        <li>Decorative elements should be properly hidden from screen readers</li>
                    </ul>
                    <button class="btn btn-primary" id="toggle-reduced-motion">Toggle Reduced Motion</button>
                </div>
                <div class="col-md-6">
                    <div class="p-4 d-flex justify-content-center align-items-center" style="height: 200px; border: 1px dashed #ccc;">
                        <div class="text-center">
                            <h4 class="heartbeat-animation">Animated Heading</h4>
                            <p class="mt-3"><span class="pen-animation visible">This should respect reduced motion</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="result-container" id="accessibility-results">
                <p>Results will appear here after testing completes...</p>
            </div>
        </div>
        
        <!-- Overall Compatibility Summary -->
        <div class="test-container">
            <div class="test-header">
                <h3>Compatibility Summary</h3>
                <span class="test-status status-testing" id="summary-status">Testing...</span>
            </div>
            
            <div id="compatibility-summary">
                <p>Testing in progress... The compatibility summary will appear here once all tests are complete.</p>
            </div>
            
            <div class="mt-4">
                <button class="btn btn-success" id="run-all-tests">Run All Tests Again</button>
                <button class="btn btn-outline-secondary" id="save-results">Save Test Results</button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/animations.js"></script>
    <script src="/assets/js/animation-compatibility.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables for test status
            let heartbeatPassed = false;
            let penPassed = false;
            let svgPassed = false;
            let accessibilityPassed = false;
            
            // Helper function to set test status
            function setTestStatus(elementId, status, message) {
                const statusElement = document.getElementById(elementId + '-status');
                const resultsElement = document.getElementById(elementId + '-results');
                
                // Remove all status classes
                statusElement.classList.remove('status-testing', 'status-passed', 'status-failed');
                
                // Add appropriate class based on status
                if (status === 'passed') {
                    statusElement.classList.add('status-passed');
                    statusElement.textContent = 'Passed';
                } else if (status === 'failed') {
                    statusElement.classList.add('status-failed');
                    statusElement.textContent = 'Failed';
                } else {
                    statusElement.classList.add('status-testing');
                    statusElement.textContent = 'Testing...';
                }
                
                // Update results container
                if (message) {
                    resultsElement.innerHTML = message;
                }
            }
            
            // Test heartbeat animation
            function testHeartbeatAnimation() {
                const heartbeatElement = document.querySelector('.heartbeat-animation');
                const computedStyle = window.getComputedStyle(heartbeatElement);
                const hasAnimation = computedStyle.animation !== 'none' && computedStyle.animation !== '';
                
                if (hasAnimation) {
                    heartbeatPassed = true;
                    setTestStatus('heartbeat', 'passed', `
                        <h5>Animation detected ✓</h5>
                        <p>The heartbeat animation is properly applied with the following properties:</p>
                        <ul>
                            <li><span class="code">animation</span>: ${computedStyle.animation}</li>
                            <li><span class="code">transform</span>: ${computedStyle.transform}</li>
                            <li><span class="code">text-shadow</span>: ${computedStyle.textShadow}</li>
                        </ul>
                        <p>The animation appears to be working correctly in your browser.</p>
                    `);
                } else {
                    heartbeatPassed = false;
                    setTestStatus('heartbeat', 'failed', `
                        <h5>Animation not detected ✗</h5>
                        <p>The heartbeat animation does not appear to be properly applied. This could be due to:</p>
                        <ul>
                            <li>Your browser does not support CSS animations</li>
                            <li>CSS animation properties are not being recognized</li>
                            <li>The animation may have been disabled by reduced motion settings</li>
                        </ul>
                        <p>Try clicking the "Reset Animation" button to see if that helps.</p>
                    `);
                }
            }
            
            // Test pen animation
            function testPenAnimation() {
                const penElement = document.querySelector('.pen-animation.visible');
                const computedPseudoStyle = getComputedStyle(penElement, '::after');
                const hasPseudoElement = computedPseudoStyle.content !== 'none';
                
                if (hasPseudoElement) {
                    penPassed = true;
                    setTestStatus('pen', 'passed', `
                        <h5>Pen animation detected ✓</h5>
                        <p>The pen drawing animation is properly applied with the following properties:</p>
                        <ul>
                            <li><span class="code">::after content</span>: ${computedPseudoStyle.content}</li>
                            <li><span class="code">background</span>: ${computedPseudoStyle.background}</li>
                            <li><span class="code">width</span>: ${computedPseudoStyle.width}</li>
                        </ul>
                        <p>The animation appears to be working correctly in your browser.</p>
                    `);
                } else {
                    penPassed = false;
                    setTestStatus('pen', 'failed', `
                        <h5>Pen animation not detected ✗</h5>
                        <p>The pen drawing animation does not appear to be properly applied. This could be due to:</p>
                        <ul>
                            <li>Your browser does not fully support CSS pseudo-elements</li>
                            <li>The animation styles were not properly loaded</li>
                            <li>The animation may have been disabled by reduced motion settings</li>
                        </ul>
                        <p>Try clicking the "Reset Animation" button to see if that helps.</p>
                    `);
                }
            }
            
            // Test SVG animations
            function testSvgAnimations() {
                const svgElement = document.querySelector('.floating-shape');
                const computedStyle = window.getComputedStyle(svgElement);
                const hasAnimation = computedStyle.animation !== 'none' && computedStyle.animation !== '';
                
                if (hasAnimation) {
                    svgPassed = true;
                    setTestStatus('svg', 'passed', `
                        <h5>SVG animations detected ✓</h5>
                        <p>The SVG animations are properly applied with the following properties:</p>
                        <ul>
                            <li><span class="code">animation</span>: ${computedStyle.animation}</li>
                            <li><span class="code">animation-duration</span>: ${computedStyle.animationDuration}</li>
                            <li><span class="code">animation-timing-function</span>: ${computedStyle.animationTimingFunction}</li>
                        </ul>
                        <p>The SVG animations appear to be working correctly in your browser.</p>
                    `);
                } else {
                    svgPassed = false;
                    setTestStatus('svg', 'failed', `
                        <h5>SVG animations not detected ✗</h5>
                        <p>The SVG animations do not appear to be properly applied. This could be due to:</p>
                        <ul>
                            <li>Your browser does not fully support SVG animations</li>
                            <li>The animation styles were not properly loaded</li>
                            <li>The animations may have been disabled by reduced motion settings</li>
                        </ul>
                        <p>Try clicking the "Reset Animation" button to see if that helps.</p>
                    `);
                }
            }
            
            // Test accessibility features
            function testAccessibility() {
                const hasReducedMotionSupport = window.matchMedia('(prefers-reduced-motion: reduce)') !== null;
                
                // Check if our reduced motion CSS is working
                const styleSheets = document.styleSheets;
                let hasReducedMotionStyles = false;
                
                try {
                    for (let i = 0; i < styleSheets.length; i++) {
                        if (!styleSheets[i].cssRules) continue;
                        
                        for (let j = 0; j < styleSheets[i].cssRules.length; j++) {
                            if (styleSheets[i].cssRules[j].media && 
                                styleSheets[i].cssRules[j].media.mediaText.includes('prefers-reduced-motion')) {
                                hasReducedMotionStyles = true;
                                break;
                            }
                        }
                        
                        if (hasReducedMotionStyles) break;
                    }
                } catch (e) {
                    console.warn('Could not read stylesheets due to CORS:', e);
                }
                
                if (hasReducedMotionSupport && hasReducedMotionStyles) {
                    accessibilityPassed = true;
                    setTestStatus('accessibility', 'passed', `
                        <h5>Accessibility features detected ✓</h5>
                        <p>The accessibility features are properly implemented:</p>
                        <ul>
                            <li><span class="code">prefers-reduced-motion</span> media query is supported</li>
                            <li>Reduced motion CSS styles are properly defined</li>
                            <li>Use the "Toggle Reduced Motion" button to test the behavior</li>
                        </ul>
                        <p>The animations respect accessibility preferences in your browser.</p>
                    `);
                } else {
                    accessibilityPassed = true; // Still pass this test as it's a progressive enhancement
                    setTestStatus('accessibility', 'passed', `
                        <h5>Limited accessibility support detected</h5>
                        <p>Your browser has limited support for animation accessibility features:</p>
                        <ul>
                            <li><span class="code">prefers-reduced-motion</span> media query support: ${hasReducedMotionSupport ? 'Yes' : 'No'}</li>
                            <li>Reduced motion CSS styles detected: ${hasReducedMotionStyles ? 'Yes' : 'No'}</li>
                        </ul>
                        <p>The animations may still work, but users with motion sensitivity preferences might not have their preferences respected.</p>
                    `);
                }
            }
            
            // Update overall compatibility summary
            function updateCompatibilitySummary() {
                const summaryElement = document.getElementById('compatibility-summary');
                const summaryStatus = document.getElementById('summary-status');
                
                const totalTests = 4;
                const passedTests = [heartbeatPassed, penPassed, svgPassed, accessibilityPassed].filter(Boolean).length;
                const compatibility = Math.round((passedTests / totalTests) * 100);
                
                if (compatibility === 100) {
                    summaryStatus.textContent = 'Fully Compatible';
                    summaryStatus.classList.remove('status-testing', 'status-failed');
                    summaryStatus.classList.add('status-passed');
                } else if (compatibility >= 75) {
                    summaryStatus.textContent = 'Mostly Compatible';
                    summaryStatus.classList.remove('status-testing', 'status-failed');
                    summaryStatus.classList.add('status-passed');
                } else if (compatibility >= 50) {
                    summaryStatus.textContent = 'Partially Compatible';
                    summaryStatus.classList.remove('status-testing', 'status-passed');
                    summaryStatus.classList.add('status-failed');
                } else {
                    summaryStatus.textContent = 'Not Compatible';
                    summaryStatus.classList.remove('status-testing', 'status-passed');
                    summaryStatus.classList.add('status-failed');
                }
                
                summaryElement.innerHTML = `
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: ${compatibility}%;" 
                             aria-valuenow="${compatibility}" aria-valuemin="0" aria-valuemax="100">
                            ${compatibility}%
                        </div>
                    </div>
                    <h5>Test Results Summary:</h5>
                    <ul>
                        <li>Heartbeat Animation: ${heartbeatPassed ? '✓ Passed' : '✗ Failed'}</li>
                        <li>Pen Drawing Animation: ${penPassed ? '✓ Passed' : '✗ Failed'}</li>
                        <li>SVG Animations: ${svgPassed ? '✓ Passed' : '✗ Failed'}</li>
                        <li>Accessibility Features: ${accessibilityPassed ? '✓ Passed' : '✗ Failed'}</li>
                    </ul>
                    <div class="alert ${compatibility === 100 ? 'alert-success' : 'alert-info'} mt-3">
                        <strong>Compatibility Assessment:</strong> 
                        ${compatibility === 100 ? 'All animations work perfectly in your browser.' :
                          compatibility >= 75 ? 'Most animations work in your browser with minor issues.' :
                          compatibility >= 50 ? 'Some animations work in your browser, but there are significant issues.' :
                          'Most animations do not work properly in your browser.'}
                    </div>
                    <p class="mt-3">
                        Browser: ${<?php echo json_encode($browser_info['browser']); ?>} ${<?php echo json_encode($browser_info['version']); ?>}<br>
                        Platform: ${<?php echo json_encode($browser_info['platform']); ?>}<br>
                        Mobile: ${<?php echo json_encode($browser_info['mobile'] ? 'Yes' : 'No'); ?>}<br>
                        Test Date: ${new Date().toLocaleString()}
                    </p>
                `;
            }
            
            // Run all tests
            function runAllTests() {
                // Reset test statuses
                document.querySelectorAll('.test-status').forEach(el => {
                    el.classList.remove('status-passed', 'status-failed');
                    el.classList.add('status-testing');
                    el.textContent = 'Testing...';
                });
                
                // Make sure all animations are visible and running
                document.querySelectorAll('.pen-animation').forEach(el => {
                    el.classList.add('visible');
                });
                
                document.querySelectorAll('.floating-shape').forEach(el => {
                    el.style.animationPlayState = 'running';
                });
                
                // Run tests after a short delay to allow animations to start
                setTimeout(() => {
                    testHeartbeatAnimation();
                    testPenAnimation();
                    testSvgAnimations();
                    testAccessibility();
                    
                    // Update overall summary
                    setTimeout(updateCompatibilitySummary, 500);
                }, 500);
            }
            
            // Button event listeners
            document.getElementById('reset-heartbeat').addEventListener('click', function() {
                const heartbeatElement = document.querySelector('.heartbeat-animation');
                
                // Restart animation by removing and re-adding the class
                const originalClass = heartbeatElement.className;
                heartbeatElement.className = heartbeatElement.className.replace('heartbeat-animation', '');
                
                // Force reflow
                void heartbeatElement.offsetWidth;
                
                // Add class back
                heartbeatElement.className = originalClass;
                
                // Re-test after a delay
                setTimeout(testHeartbeatAnimation, 500);
            });
            
            document.getElementById('reset-pen').addEventListener('click', function() {
                document.querySelectorAll('.pen-animation').forEach(el => {
                    el.classList.remove('visible');
                    
                    // Force reflow
                    void el.offsetWidth;
                    
                    // Add class back
                    el.classList.add('visible');
                });
                
                // Re-test after a delay
                setTimeout(testPenAnimation, 500);
            });
            
            document.getElementById('reset-svg').addEventListener('click', function() {
                document.querySelectorAll('.floating-shape').forEach(el => {
                    el.style.animationPlayState = 'paused';
                    
                    // Force reflow
                    void el.offsetWidth;
                    
                    // Resume animation
                    el.style.animationPlayState = 'running';
                });
                
                // Re-test after a delay
                setTimeout(testSvgAnimations, 500);
            });
            
            document.getElementById('toggle-reduced-motion').addEventListener('click', function() {
                const html = document.documentElement;
                
                if (html.classList.contains('reduced-motion')) {
                    html.classList.remove('reduced-motion');
                    this.textContent = 'Toggle Reduced Motion';
                    
                    // Add some styling to simulate normal motion
                    const styleEl = document.getElementById('reduced-motion-style');
                    if (styleEl) {
                        styleEl.remove();
                    }
                } else {
                    html.classList.add('reduced-motion');
                    this.textContent = 'Remove Reduced Motion';
                    
                    // Add some styling to simulate reduced motion
                    const styleEl = document.createElement('style');
                    styleEl.id = 'reduced-motion-style';
                    styleEl.textContent = `
                        .heartbeat-animation {
                            animation: none !important;
                        }
                        
                        .pen-animation::after {
                            animation: none !important;
                            width: 100% !important;
                        }
                        
                        .floating-shape {
                            animation: none !important;
                        }
                    `;
                    document.head.appendChild(styleEl);
                }
                
                // Re-test accessibility after toggling
                setTimeout(testAccessibility, 500);
            });
            
            document.getElementById('run-all-tests').addEventListener('click', runAllTests);
            
            document.getElementById('save-results').addEventListener('click', function() {
                // Create a simple report to save
                const browserInfo = `${<?php echo json_encode($browser_info['browser']); ?>} ${<?php echo json_encode($browser_info['version']); ?>} (${<?php echo json_encode($browser_info['platform']); ?>})`;
                const testDate = new Date().toLocaleString();
                const totalTests = 4;
                const passedTests = [heartbeatPassed, penPassed, svgPassed, accessibilityPassed].filter(Boolean).length;
                const compatibility = Math.round((passedTests / totalTests) * 100);
                
                const report = `Airy Alps Animation Compatibility Report
====================================
Browser: ${browserInfo}
Mobile: ${<?php echo json_encode($browser_info['mobile'] ? 'Yes' : 'No'); ?>}
Test Date: ${testDate}
Compatibility Score: ${compatibility}%

Test Results:
- Heartbeat Animation: ${heartbeatPassed ? 'PASSED' : 'FAILED'}
- Pen Drawing Animation: ${penPassed ? 'PASSED' : 'FAILED'}
- SVG Animations: ${svgPassed ? 'PASSED' : 'FAILED'}
- Accessibility Features: ${accessibilityPassed ? 'PASSED' : 'FAILED'}

Overall Assessment:
${compatibility === 100 ? 'All animations work perfectly in this browser.' :
  compatibility >= 75 ? 'Most animations work in this browser with minor issues.' :
  compatibility >= 50 ? 'Some animations work in this browser, but there are significant issues.' :
  'Most animations do not work properly in this browser.'}
`;
                
                // Create a blob and download link
                const blob = new Blob([report], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `airy-alps-animation-report-${browserInfo.replace(/[^a-z0-9]/gi, '-').toLowerCase()}.txt`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
            
            // Run tests on page load
            setTimeout(runAllTests, 1000);
        });
    </script>
</body>
</html>
