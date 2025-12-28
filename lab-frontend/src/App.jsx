import { useEffect, useState } from 'react'

function App() {
  const [labs, setLabs] = useState([])

  useEffect(() => {
    // هذا السطر يربط الرياكت بعنوان الباك اند الذي جهزتيه سابقاً
    fetch('http://127.0.0.1:8000/api/labs')
      .then(response => response.json())
      .then(data => setLabs(data))
      .catch(error => console.error('خطأ في جلب البيانات:', error))
  }, [])

  return (
    <div style={{ padding: '20px', direction: 'rtl', fontFamily: 'Arial' }}>
      <h1 style={{ color: '#2c3e50' }}>نظام إدارة المختبرات - لوحة البيانات</h1>
      
      <table style={{ width: '100%', borderCollapse: 'collapse', marginTop: '20px', boxShadow: '0 2px 5px rgba(0,0,0,0.1)' }}>
        <thead>
          <tr style={{ backgroundColor: '#3498db', color: 'white' }}>
            <th style={{ padding: '12px', border: '1px solid #ddd' }}>ID</th>
            <th style={{ padding: '12px', border: '1px solid #ddd' }}>اسم المختبر</th>
            <th style={{ padding: '12px', border: '1px solid #ddd' }}>الطابق</th>
            <th style={{ padding: '12px', border: '1px solid #ddd' }}>الحالة</th>
          </tr>
        </thead>
        <tbody>
          {labs.length > 0 ? labs.map(lab => (
            <tr key={lab.id} style={{ textAlign: 'center' }}>
              <td style={{ padding: '10px', border: '1px solid #ddd' }}>{lab.id}</td>
              <td style={{ padding: '10px', border: '1px solid #ddd' }}>{lab.name}</td>
              <td style={{ padding: '10px', border: '1px solid #ddd' }}>{lab.floor}</td>
              <td style={{ padding: '10px', border: '1px solid #ddd', color: lab.status === 'Available' ? 'green' : 'red' }}>
                {lab.status}
              </td>
            </tr>
          )) : (
            <tr>
              <td colSpan="4" style={{ padding: '20px' }}>جاري تحميل البيانات من السيرفر... تأكدي من تشغيل Laravel</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  )
}

export default App

