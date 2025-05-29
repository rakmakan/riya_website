/**
 * Airy Alps Animation Performance Monitor
 * This utility helps identify and diagnose potential animation performance issues
 * by measuring frame rates and jank when animations are running.
 */

class AnimationPerformanceMonitor {
    constructor(options = {}) {
        this.options = Object.assign({
            targetFrameRate: 60,
            warningThreshold: 45, // FPS below this will trigger warnings
            criticalThreshold: 30, // FPS below this will trigger critical warnings
            sampleSize: 60, // How many frames to measure for reporting
            reportInterval: 5000, // Report frequency in ms
            logging: true, // Whether to log to console
            onReport: null // Callback function for reports
        }, options);
        
        this.isMonitoring = false;
        this.frameTimestamps = [];
        this.frameTimes = [];
        this.longFrames = 0; // Frames that take too long (jank)
        this.startTime = 0;
        this.lastReportTime = 0;
        this.animationElements = {
            heartbeat: [],
            pen: [],
            svg: []
        };
        
        // Bind methods
        this.start = this.start.bind(this);
        this.stop = this.stop.bind(this);
        this.recordFrame = this.recordFrame.bind(this);
        this.generateReport = this.generateReport.bind(this);
    }
    
    /**
     * Start monitoring animation performance
     */
    start() {
        if (this.isMonitoring) return;
        
        this.isMonitoring = true;
        this.frameTimestamps = [];
        this.frameTimes = [];
        this.longFrames = 0;
        this.startTime = performance.now();
        this.lastReportTime = this.startTime;
        
        // Find animation elements to monitor
        this.findAnimationElements();
        
        // Start the monitoring loop
        this.requestId = requestAnimationFrame(this.recordFrame);
        
        if (this.options.logging) {
            console.log('🔍 Animation performance monitoring started');
        }
    }
    
    /**
     * Stop monitoring animation performance
     */
    stop() {
        if (!this.isMonitoring) return;
        
        this.isMonitoring = false;
        cancelAnimationFrame(this.requestId);
        
        // Generate final report
        const finalReport = this.generateReport(true);
        
        if (this.options.logging) {
            console.log('⏹️ Animation performance monitoring stopped');
            console.table(finalReport.metrics);
        }
        
        return finalReport;
    }
    
    /**
     * Record a single animation frame
     */
    recordFrame(timestamp) {
        if (!this.isMonitoring) return;
        
        // Record frame timestamp
        this.frameTimestamps.push(timestamp);
        
        // Calculate frame time if we have at least 2 frames
        if (this.frameTimestamps.length > 1) {
            const lastTimestamp = this.frameTimestamps[this.frameTimestamps.length - 2];
            const frameTime = timestamp - lastTimestamp;
            this.frameTimes.push(frameTime);
            
            // Check for long frames (jank)
            const frameTimeBudget = 1000 / this.options.targetFrameRate;
            if (frameTime > frameTimeBudget * 1.5) {
                this.longFrames++;
            }
            
            // Limit the size of our arrays
            if (this.frameTimestamps.length > this.options.sampleSize) {
                this.frameTimestamps.shift();
                this.frameTimes.shift();
            }
        }
        
        // Check if it's time for a report
        const now = performance.now();
        if (now - this.lastReportTime >= this.options.reportInterval) {
            const report = this.generateReport();
            this.lastReportTime = now;
            
            if (this.options.logging) {
                const fps = report.metrics.averageFps;
                let statusSymbol = '✅';
                if (fps < this.options.criticalThreshold) {
                    statusSymbol = '🔴';
                } else if (fps < this.options.warningThreshold) {
                    statusSymbol = '🟡';
                }
                
                console.log(`${statusSymbol} FPS: ${fps.toFixed(1)}, Jank: ${report.metrics.jankPercentage.toFixed(1)}%`);
            }
            
            // Call the report callback if provided
            if (typeof this.options.onReport === 'function') {
                this.options.onReport(report);
            }
        }
        
        // Continue the loop
        this.requestId = requestAnimationFrame(this.recordFrame);
    }
    
    /**
     * Generate a performance report
     */
    generateReport(isFinal = false) {
        // Skip if we don't have enough data
        if (this.frameTimes.length < 2) {
            return {
                timestamp: performance.now(),
                metrics: {
                    averageFps: this.options.targetFrameRate,
                    jankPercentage: 0,
                    totalFrames: 0,
                    longFrames: 0,
                    averageFrameTime: 1000 / this.options.targetFrameRate
                },
                elementCounts: {
                    heartbeat: this.animationElements.heartbeat.length,
                    pen: this.animationElements.pen.length,
                    svg: this.animationElements.svg.length
                },
                warnings: [],
                recommendations: []
            };
        }
        
        // Calculate average frame time
        const averageFrameTime = this.frameTimes.reduce((sum, time) => sum + time, 0) / this.frameTimes.length;
        
        // Calculate FPS from average frame time
        const averageFps = 1000 / averageFrameTime;
        
        // Calculate jank percentage
        const totalFrames = this.frameTimes.length;
        const jankPercentage = (this.longFrames / totalFrames) * 100;
        
        // Generate warnings and recommendations
        const warnings = [];
        const recommendations = [];
        
        if (averageFps < this.options.criticalThreshold) {
            warnings.push('CRITICAL: Very low frame rate detected');
        } else if (averageFps < this.options.warningThreshold) {
            warnings.push('WARNING: Below optimal frame rate');
        }
        
        if (jankPercentage > 10) {
            warnings.push('WARNING: High amount of janky frames detected');
        }
        
        // Add recommendations based on issues
        if (this.animationElements.svg.length > 10) {
            recommendations.push('Consider reducing the number of animated SVG elements');
        }
        
        if (averageFps < this.options.warningThreshold) {
            recommendations.push('Consider using simpler animations or reducing the number of animated elements');
            recommendations.push('Add "will-change: transform" to critical animation elements');
        }
        
        if (isFinal && jankPercentage > 5) {
            recommendations.push('Use requestAnimationFrame for JavaScript animations instead of setInterval/setTimeout');
            recommendations.push('Ensure CSS animations only animate transform and opacity properties when possible');
        }
        
        return {
            timestamp: performance.now(),
            metrics: {
                averageFps,
                jankPercentage,
                totalFrames,
                longFrames: this.longFrames,
                averageFrameTime
            },
            elementCounts: {
                heartbeat: this.animationElements.heartbeat.length,
                pen: this.animationElements.pen.length,
                svg: this.animationElements.svg.length
            },
            warnings,
            recommendations
        };
    }
    
    /**
     * Find and categorize animated elements on the page
     */
    findAnimationElements() {
        // Reset counts
        this.animationElements = {
            heartbeat: [],
            pen: [],
            svg: []
        };
        
        // Find heartbeat elements
        this.animationElements.heartbeat = Array.from(document.querySelectorAll('.heartbeat-animation'));
        
        // Find pen animation elements
        this.animationElements.pen = Array.from(document.querySelectorAll('.pen-animation'));
        
        // Find SVG animation elements
        this.animationElements.svg = Array.from(document.querySelectorAll('.floating-shape'));
    }
    
    /**
     * Create a visual performance meter on the page
     * @param {string} parentSelector - Selector for the parent element to attach to
     * @returns {Object} - Control methods for the meter
     */
    createPerformanceMeter(parentSelector = 'body') {
        const parent = document.querySelector(parentSelector);
        if (!parent) return null;
        
        // Create meter container
        const meterContainer = document.createElement('div');
        meterContainer.className = 'airy-perf-meter';
        meterContainer.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            min-width: 200px;
            transition: opacity 0.3s;
        `;
        
        // Create meter content
        const fpsCounter = document.createElement('div');
        fpsCounter.className = 'airy-perf-fps';
        fpsCounter.textContent = `FPS: ${this.options.targetFrameRate}`;
        fpsCounter.style.marginBottom = '5px';
        
        const jankCounter = document.createElement('div');
        jankCounter.className = 'airy-perf-jank';
        jankCounter.textContent = 'Jank: 0%';
        jankCounter.style.marginBottom = '5px';
        
        const elementCounter = document.createElement('div');
        elementCounter.className = 'airy-perf-elements';
        elementCounter.textContent = 'Animated Elements: 0';
        elementCounter.style.marginBottom = '5px';
        
        const graph = document.createElement('canvas');
        graph.className = 'airy-perf-graph';
        graph.width = 180;
        graph.height = 40;
        graph.style.border = '1px solid rgba(255, 255, 255, 0.2)';
        
        const ctx = graph.getContext('2d');
        ctx.fillStyle = '#111';
        ctx.fillRect(0, 0, graph.width, graph.height);
        
        const toggleButton = document.createElement('button');
        toggleButton.textContent = 'Hide Details';
        toggleButton.style.cssText = `
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 4px 8px;
            margin-top: 5px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 11px;
            cursor: pointer;
        `;
        
        // Add elements to container
        meterContainer.appendChild(fpsCounter);
        meterContainer.appendChild(jankCounter);
        meterContainer.appendChild(elementCounter);
        meterContainer.appendChild(graph);
        meterContainer.appendChild(toggleButton);
        
        // Add container to parent
        parent.appendChild(meterContainer);
        
        // Graph data
        const graphData = [];
        const maxDataPoints = graph.width;
        
        // Update handler
        const updateMeter = (report) => {
            const { metrics, elementCounts } = report;
            
            // Update counters
            fpsCounter.textContent = `FPS: ${metrics.averageFps.toFixed(1)}`;
            jankCounter.textContent = `Jank: ${metrics.jankPercentage.toFixed(1)}%`;
            elementCounter.textContent = `Animated Elements: ${
                elementCounts.heartbeat + elementCounts.pen + elementCounts.svg
            }`;
            
            // Update color based on performance
            if (metrics.averageFps < this.options.criticalThreshold) {
                fpsCounter.style.color = '#ff4d4d';
            } else if (metrics.averageFps < this.options.warningThreshold) {
                fpsCounter.style.color = '#ffcc00';
            } else {
                fpsCounter.style.color = '#66ff66';
            }
            
            // Update graph
            graphData.push(metrics.averageFps);
            
            // Limit data points
            if (graphData.length > maxDataPoints) {
                graphData.shift();
            }
            
            // Draw graph
            ctx.fillStyle = '#111';
            ctx.fillRect(0, 0, graph.width, graph.height);
            
            // Draw target line
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.beginPath();
            const targetY = graph.height - (this.options.targetFrameRate / 60) * graph.height;
            ctx.moveTo(0, targetY);
            ctx.lineTo(graph.width, targetY);
            ctx.stroke();
            
            // Draw warning threshold
            ctx.strokeStyle = 'rgba(255, 204, 0, 0.3)';
            ctx.beginPath();
            const warningY = graph.height - (this.options.warningThreshold / 60) * graph.height;
            ctx.moveTo(0, warningY);
            ctx.lineTo(graph.width, warningY);
            ctx.stroke();
            
            // Draw critical threshold
            ctx.strokeStyle = 'rgba(255, 77, 77, 0.3)';
            ctx.beginPath();
            const criticalY = graph.height - (this.options.criticalThreshold / 60) * graph.height;
            ctx.moveTo(0, criticalY);
            ctx.lineTo(graph.width, criticalY);
            ctx.stroke();
            
            // Draw FPS line
            ctx.strokeStyle = '#66ff66';
            ctx.beginPath();
            graphData.forEach((fps, i) => {
                const x = i * (graph.width / maxDataPoints);
                // Clamp FPS to 0-60 range for visualization
                const clampedFps = Math.min(Math.max(fps, 0), 60);
                const y = graph.height - (clampedFps / 60) * graph.height;
                
                if (i === 0) {
                    ctx.moveTo(x, y);
                } else {
                    ctx.lineTo(x, y);
                }
            });
            ctx.stroke();
        };
        
        // Toggle button handler
        let isExpanded = true;
        toggleButton.addEventListener('click', () => {
            isExpanded = !isExpanded;
            graph.style.display = isExpanded ? 'block' : 'none';
            elementCounter.style.display = isExpanded ? 'block' : 'none';
            jankCounter.style.display = isExpanded ? 'block' : 'none';
            toggleButton.textContent = isExpanded ? 'Hide Details' : 'Show Details';
            meterContainer.style.minWidth = isExpanded ? '200px' : 'auto';
        });
        
        // Add event handlers for dragging
        let isDragging = false;
        let offsetX, offsetY;
        
        meterContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            offsetX = e.clientX - meterContainer.getBoundingClientRect().left;
            offsetY = e.clientY - meterContainer.getBoundingClientRect().top;
            meterContainer.style.cursor = 'grabbing';
        });
        
        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            const x = e.clientX - offsetX;
            const y = e.clientY - offsetY;
            
            // Keep within viewport bounds
            const maxX = window.innerWidth - meterContainer.offsetWidth;
            const maxY = window.innerHeight - meterContainer.offsetHeight;
            
            meterContainer.style.right = 'auto';
            meterContainer.style.left = `${Math.max(0, Math.min(maxX, x))}px`;
            meterContainer.style.bottom = 'auto';
            meterContainer.style.top = `${Math.max(0, Math.min(maxY, y))}px`;
        });
        
        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                meterContainer.style.cursor = 'grab';
            }
        });
        
        // Initialize appearance
        meterContainer.style.cursor = 'grab';
        
        // Start updating the meter with performance data
        this.options.onReport = updateMeter;
        
        // Return control methods
        return {
            show: () => { meterContainer.style.opacity = '1'; },
            hide: () => { meterContainer.style.opacity = '0'; },
            remove: () => { parent.removeChild(meterContainer); },
            update: updateMeter
        };
    }
}

// Create a global instance
window.airyAlpsPerformance = new AnimationPerformanceMonitor();

// Auto-initialize when the page loads
document.addEventListener('DOMContentLoaded', () => {
    // Start monitoring if animations are present
    const hasAnimations = 
        document.querySelector('.heartbeat-animation') || 
        document.querySelector('.pen-animation') ||
        document.querySelector('.floating-shape');
    
    if (hasAnimations) {
        console.log('🎬 Airy Alps animations detected, starting performance monitoring');
        
        // Wait for animations to start
        setTimeout(() => {
            window.airyAlpsPerformance.start();
        }, 1000);
    }
});

// Add meter to performance testing page if it exists
if (window.location.pathname.includes('test-animations')) {
    document.addEventListener('DOMContentLoaded', () => {
        window.airyAlpsPerformance.createPerformanceMeter('body');
        window.airyAlpsPerformance.start();
    });
}
