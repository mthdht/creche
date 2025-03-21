import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { type Transmission } from '@/types';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const calculateAge = (birthdate: string) => {
    const now = new Date();
    const birthDate = new Date(birthdate);
    
    let years = now.getFullYear() - birthDate.getFullYear();
    let months = now.getMonth() - birthDate.getMonth();
    
    // Si le mois actuel est avant le mois de naissance, on retire 1 an et on ajuste les mois
    if (months < 0) {
      years--;
      months += 12;
    }
  
    // Si l'enfant n'a pas encore un an, afficher en mois uniquement
    if (years === 0) {
      return `${months} mois`;
    }
  
    // Si l'enfant a plus d'un an, afficher l'âge en années et mois
    if (months === 0) {
      return `${years} an${years > 1 ? 's' : ''}`;
    }
  
    return `${years} an${years > 1 ? 's' : ''} et ${months} mois`;
};

export function transmissionByDate(transmissions: Transmission[]) {
  return Object.entries(
      transmissions.reduce<Record<string, Transmission[]>>((acc, transmission) => {
          const dateKey = transmission.datetime.split(' ')[0];
          acc[dateKey] = acc[dateKey] || [];
          acc[dateKey].push(transmission);
          return acc;
      }, {})
  ).sort().reverse();
  // wait for browsers to accept groupBy
  //return Object.entries(Object.groupBy(transmissions, ({date}) => date.split(' ')[0])).sort().reverse()
}

export function readableTime(datetime:string) {
  const time = datetime.split(' ')[1].split(':')

  return time[0] + 'H' + time[1]
}