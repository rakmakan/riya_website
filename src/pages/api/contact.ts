import type { APIRoute } from 'astro';

export const prerender = false;

export const POST: APIRoute = async ({ request }) => {
  try {
    const body = await request.json();
    const { name, email, website, business, challenge, referral, _honey } = body;

    // Honeypot bot trap
    if (_honey) {
      return new Response(JSON.stringify({ success: true }), { status: 200 });
    }

    // Validate required fields
    if (!name || !email || !business || !challenge) {
      return new Response(
        JSON.stringify({ error: 'Missing required fields' }),
        { status: 400 }
      );
    }

    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return new Response(
        JSON.stringify({ error: 'Invalid email address' }),
        { status: 400 }
      );
    }

    const resendApiKey = import.meta.env.RESEND_API_KEY;
    const toEmail = import.meta.env.CONTACT_EMAIL_TO || 'riyauppal777@gmail.com';

    if (!resendApiKey) {
      console.error('RESEND_API_KEY not configured');
      return new Response(
        JSON.stringify({ error: 'Email service not configured' }),
        { status: 500 }
      );
    }

    // Send email via Resend
    const emailResponse = await fetch('https://api.resend.com/emails', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${resendApiKey}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        from: 'Airy Alps Contact Form <onboarding@resend.dev>',
        to: [toEmail],
        reply_to: email,
        subject: `New inquiry from ${name} — Airy Alps`,
        html: `
          <div style="font-family: Georgia, serif; max-width: 600px; margin: 0 auto; color: #1e1c18;">
            <div style="border-bottom: 1px solid #e5d5b5; padding-bottom: 24px; margin-bottom: 24px;">
              <h2 style="font-size: 24px; font-weight: 500; margin: 0;">New contact form submission</h2>
              <p style="margin: 4px 0 0; color: #999; font-size: 14px;">Airy Alps — airyalps.com</p>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; width: 140px; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Name</span>
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <strong>${escapeHtml(name)}</strong>
                </td>
              </tr>
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Email</span>
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <a href="mailto:${escapeHtml(email)}" style="color: #b5714e;">${escapeHtml(email)}</a>
                </td>
              </tr>
              ${website ? `
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Website</span>
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  ${escapeHtml(website)}
                </td>
              </tr>
              ` : ''}
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Business</span>
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  ${escapeHtml(business)}
                </td>
              </tr>
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Challenge</span>
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f0e8d4; vertical-align: top;">
                  ${escapeHtml(challenge)}
                </td>
              </tr>
              ${referral ? `
              <tr>
                <td style="padding: 12px 0; vertical-align: top;">
                  <span style="font-size: 11px; font-family: sans-serif; text-transform: uppercase; letter-spacing: 0.1em; color: #7c8c6e; font-weight: 600;">Found via</span>
                </td>
                <td style="padding: 12px 0; vertical-align: top;">
                  ${escapeHtml(referral)}
                </td>
              </tr>
              ` : ''}
            </table>

            <div style="margin-top: 32px; padding: 20px; background: #f8f4ec; border-left: 3px solid #b5714e;">
              <p style="margin: 0; font-size: 13px; color: #7c8c6e; font-family: sans-serif;">
                Reply directly to this email to respond to ${escapeHtml(name)}.
              </p>
            </div>
          </div>
        `,
      }),
    });

    if (!emailResponse.ok) {
      const errorData = await emailResponse.json();
      console.error('Resend error:', errorData);
      return new Response(
        JSON.stringify({ error: 'Failed to send email' }),
        { status: 500 }
      );
    }

    return new Response(
      JSON.stringify({ success: true }),
      {
        status: 200,
        headers: { 'Content-Type': 'application/json' },
      }
    );
  } catch (err) {
    console.error('Contact form error:', err);
    return new Response(
      JSON.stringify({ error: 'Internal server error' }),
      { status: 500 }
    );
  }
};

function escapeHtml(str: string): string {
  return str
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}
