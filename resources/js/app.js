const pages = [
    { name: "Dashboard", keywords: ["dashboard", "beranda"], url: window.pageUrls.dashboard },
    { name: "Teacher", keywords: ["teacher", "guru", "tentor"], url: window.pageUrls.register },
    { name: "Course", keywords: ["course", "kursus", "kelas"], url: window.pageUrls.courseView },
    { name: "Schedule", keywords: ["schedule", "jadwal"], url: window.pageUrls.jadwalIndex },
    { name: "Report", keywords: ["report", "laporan"], url: window.pageUrls.reportsIndex }
];

// Pastikan input dengan id searchInput ada di HTML
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const query = this.value.toLowerCase();

        let bestMatch = null;
        let maxScore = 0;

        pages.forEach(page => {
            page.keywords.forEach(keyword => {
                let score = similarity(query, keyword);
                if (score > maxScore) {
                    maxScore = score;
                    bestMatch = page;
                }
            });
        });

        if (bestMatch && maxScore > 0.4) {
            window.location.href = bestMatch.url;
        } else {
            alert("Halaman tidak ditemukan.");
        }
    }
});

function similarity(str1, str2) {
    const bigrams = s => {
        let pairs = [];
        for (let i = 0; i < s.length - 1; i++) {
            pairs.push(s.slice(i, i + 2));
        }
        return pairs;
    };

    const pairs1 = bigrams(str1);
    const pairs2 = bigrams(str2);
    const union = pairs1.length + pairs2.length;

    let hits = 0;
    pairs1.forEach(x => {
        const idx = pairs2.indexOf(x);
        if (idx !== -1) {
            hits++;
            pairs2.splice(idx, 1);
        }
    });

    return (2.0 * hits) / union;
}
