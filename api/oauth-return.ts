import type { VercelRequest, VercelResponse } from '@vercel/node';

export default function handler(req: VercelRequest, res: VercelResponse) {
  const appOrigin = process.env.OAUTH_APP_ORIGIN || (() => {
    const host = req.headers.host;
    if (!host) return 'https://oxeoauth.vercel.app/api';
    const protocol = req.headers['x-forwarded-proto'] || 'https';
    return `${protocol}://${host}`;
  })();

  const queryString = req.url?.split('?')[1] ?? '';
  const redirectUrl = `${appOrigin.replace(/\/+$/, '')}/oauth-return${queryString ? `?${queryString}` : ''}`;

  res.writeHead(302, {
    Location: redirectUrl,
  });
  res.end();
}
