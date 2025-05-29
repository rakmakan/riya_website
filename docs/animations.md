# Airy Alps Animations

This document provides information about the custom animations used on the Airy Alps About page and how to customize them.

## Overview

The animations symbolize care and intentionality through two main effects:

1. **Heartbeat Animation**: A subtle scaling effect with a gentle glow applied to the main heading "I treat your brand like my own"
2. **Pen Drawing Animation**: A flowing gradient underline that appears from left to right on important text elements

These animations are designed to be subtle, elegant, and symbolize the care and craftsmanship that Airy Alps brings to brand work.

## Implementation Details

### File Structure

- **`/assets/css/animations.css`**: Contains all animation keyframes and styles
- **`/assets/js/animations.js`**: Handles interaction enhancements and accessibility features
- **`/assets/js/animation-compatibility.js`**: Ensures animations work across different browsers

### Animation Classes

#### Heartbeat Animation

```css
.heartbeat-animation {
  animation: heartbeat 4s ease-in-out infinite;
}
```

Apply this class to elements that should have the subtle heartbeat effect.

#### Pen Animation

```css
.pen-animation {
  /* Base styles */
}

.pen-animation.visible::after {
  animation: ink-flow 1.5s forwards, pen-drawing 4s ease 1.5s infinite;
}
```

Apply this class to text elements that should have the pen drawing underline effect. The `.visible` class is added via JavaScript when the element comes into view.

### Customization Options

#### Changing Animation Timing

To change how quickly the heartbeat animation pulses:

```css
.heartbeat-animation {
  animation-duration: 6s; /* Change from default 4s to slower 6s */
}
```

#### Changing Pen Animation Colors

The pen animation uses CSS variables that can be modified:

```css
:root {
  --accent-color: #1D3557;       /* Primary color */
  --secondary-accent: #E07A5F;   /* Secondary color */
}
```

#### Adding to New Elements

For headings:
```html
<h2><span class="heartbeat-animation">Important Heading</span></h2>
```

For text elements:
```html
<p>This text has <span class="pen-animation">special emphasis</span> applied.</p>
```

## Accessibility

These animations respect user preferences:

- Animations are disabled when `prefers-reduced-motion` is set to `reduce`
- Decorative elements are properly marked with `aria-hidden="true"`
- All functionality works without animations enabled
- Interactive elements have clear focus states

## Browser Compatibility

The animations are designed to work in all modern browsers:

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

Older browsers will gracefully degrade to static styling.

## Performance Considerations

These animations are optimized for performance:

1. Only transform and opacity properties are animated (GPU accelerated)
2. Animations pause when not in viewport
3. SVG animations use lightweight path manipulations
4. Mobile devices receive simplified animations when performance is limited

## Testing

A test page is available at `/test-animations.html` that can be used to verify all animations are working correctly.

## Credits

Animations designed and implemented for Airy Alps by [Your Name].
